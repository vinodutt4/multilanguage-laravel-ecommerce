<?php

namespace Botble\Ecommerce\Tables;

use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Models\ProductVariation;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Collective\Html\FormFacade as Form;
use Collective\Html\HtmlFacade as Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\EloquentDataTable;

class ProductVariationTable extends TableAbstract
{
    protected int|string $productId;

    protected Collection $productAttributeSets;

    protected $view = 'core/table::simple-table';

    protected bool $bStateSave = false;

    protected $hasOperations = true;

    protected bool $hasResponsive = false;

    protected bool $hasDigitalProduct = false;

    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        ProductVariationInterface $repository
    ) {
        parent::__construct($table, $urlGenerator);

        $this->repository = $repository;
        $this->productAttributeSets = collect();
        $this->setOption('class', $this->getOption('class') . ' table-hover-variants');

        if (is_in_admin(true) && ! Auth::user()->hasPermission('products.edit')) {
            $this->hasOperations = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->loadDataTable();

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->baseQuery()
            ->with([
                'product' => function (BelongsTo $query) {
                    $query
                        ->select([
                            'id',
                            'price',
                            'sale_price',
                            'sale_type',
                            'start_date',
                            'end_date',
                            'is_variation',
                            'image',
                            'images',
                        ]);
                    if ($this->hasDigitalProduct) {
                        $query->withCount('productFiles');
                    }
                },
                'configurableProduct' => function (BelongsTo $query) {
                    $query
                        ->select([
                            'id',
                            'price',
                            'sale_price',
                            'sale_type',
                            'start_date',
                            'end_date',
                            'is_variation',
                            'image',
                            'images',
                        ]);
                },
                'configurableProduct.productCollections:id,name,slug',
                'productAttributes:id,attribute_set_id,title,slug',
            ]);

        return $this->applyScopes($query);
    }

    protected function baseQuery(): Relation|Builder|QueryBuilder
    {
        return $this->repository
            ->getModel()
            ->whereHas('configurableProduct', function (Builder $query) {
                $query->where('configurable_product_id', $this->productId);
            });
    }

    protected function loadDataTable(): EloquentDataTable
    {
        $data = $this->table
            ->eloquent($this->query());

        foreach ($this->getProductAttributeSets()->whereNotNull('is_selected') as $attributeSet) {
            $data
                ->editColumn('set_' . $attributeSet->id, function (ProductVariation $item) use ($attributeSet) {
                    return $item->variationItems->firstWhere(function ($item) use ($attributeSet) {
                        return $item->attribute->attribute_set_id == $attributeSet->id;
                    })->attribute->title ?? '-';
                });
        }

        $data
            ->editColumn('checkbox', function (ProductVariation $item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('image', function (ProductVariation $item) {
                return $this->displayThumbnail($item->image);
            })
            ->editColumn('price', function (ProductVariation $item) {
                $salePrice = '';
                if ($item->product->front_sale_price != $item->product->price) {
                    $salePrice = Html::tag('del', format_price($item->product->price), ['class' => 'text-danger small']);
                }

                return Html::tag('div', format_price($item->product->front_sale_price)) . $salePrice;
            })
            ->editColumn('is_default', function (ProductVariation $item) {
                return Html::tag('label', Form::radio('variation_default_id', $item->id, $item->is_default, [
                    'data-url' => route('products.set-default-product-variation', $item->id),
                    'data-bs-toggle' => 'tooltip',
                    'title' => trans('plugins/ecommerce::products.set_this_variant_as_default'),
                ]));
            })
            ->editColumn('operations', function (ProductVariation $item) {
                $update = route('products.update-version', $item->id);
                $loadForm = route('products.get-version-form', $item->id);
                $delete = route('products.delete-version', $item->id);

                if (is_in_admin(true) && ! Auth::user()->hasPermission('products.edit')) {
                    $update = null;
                    $delete = null;
                }

                return view('plugins/ecommerce::products.variations.actions', compact('update', 'loadForm', 'delete', 'item'));
            });

        if ($this->hasDigitalProduct) {
            $data
                ->editColumn('digital_product', function (ProductVariation $item) {
                    return $item->product->product_files_count . Html::tag('i', '', ['class' => 'ms-1 fas fa-paperclip']);
                });
        }

        foreach ($this->getProductAttributeSets()->whereNotNull('is_selected') as $attributeSet) {
            $data
                ->filterColumn('set_' . $attributeSet->id, function ($query, $keyword) {
                    if ($keyword) {
                        $query->whereHas('variationItems', function ($query) use ($keyword) {
                            $query->whereHas('attribute', function ($query) use ($keyword) {
                                $query->where('id', $keyword);
                            });
                        });
                    }
                });
        }

        return $data;
    }

    public function setProductId(int|string $productId): self
    {
        $this->productId = $productId;
        $this->setAjaxUrl(route('products.product-variations', $this->productId));
        $this->setOption('id', $this->getOption('id') . '-' . $this->productId);

        return $this;
    }

    public function isDigitalProduct(bool $isTypeDigital = true): self
    {
        $this->hasDigitalProduct = $isTypeDigital;

        return $this;
    }

    public function setProductAttributeSets(Collection $productAttributeSets): self
    {
        $this->productAttributeSets = $productAttributeSets;

        return $this;
    }

    public function getProductAttributeSets(): Collection
    {
        if (! $this->productAttributeSets->count()) {
            $this->productAttributeSets = app(ProductAttributeSetInterface::class)->getAllWithSelected($this->productId, []);
        }

        return $this->productAttributeSets;
    }

    public function columns(): array
    {
        $columns = [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image' => [
                'title' => trans('plugins/ecommerce::products.image'),
                'width' => '100px',
                'class' => 'text-center',
                'searchable' => false,
                'orderable' => false,
            ],
        ];

        foreach ($this->getProductAttributeSets()->whereNotNull('is_selected') as $attributeSet) {
            $columns['set_' . $attributeSet->id] = [
                'title' => $attributeSet->title,
                'class' => 'text-start',
                'orderable' => false,
                'width' => '90',
                'search_data' => [
                    'attribute_set_id' => $attributeSet->id,
                    'type' => 'customSelect',
                    'placeholder' => trans('plugins/ecommerce::products.select'),
                ],
            ];
        }

        if ($this->hasDigitalProduct) {
            $columns['digital_product'] = [
                'title' => ProductTypeEnum::DIGITAL()->label(),
                'searchable' => false,
                'orderable' => false,
            ];
        }

        return array_merge($columns, [
            'price' => [
                'title' => trans('plugins/ecommerce::products.form.price'),
                'width' => '20px',
                'searchable' => false,
                'orderable' => false,
            ],
            'is_default' => [
                'title' => trans('plugins/ecommerce::products.form.is_default'),
                'width' => '100px',
                'class' => 'text-center',
                'searchable' => false,
            ],
        ]);
    }

    public function htmlInitComplete(): ?string
    {
        return 'function (settings, json) {
            EcommerceProduct.tableInitComplete(this.api(), settings, json); 
        ' . $this->htmlInitCompleteFunction() . '}';
    }
}
