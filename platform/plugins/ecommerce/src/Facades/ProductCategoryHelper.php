<?php

namespace Botble\Ecommerce\Facades;

use Botble\Ecommerce\Supports\ProductCategoryHelper as BaseProductCategoryHelper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection getAllProductCategories(array $params = [], bool $onlyParent = false)
 * @method static \Illuminate\Support\Collection getAllProductCategoriesSortByChildren()
 * @method static array getAllProductCategoriesWithChildren()
 * @method static \Illuminate\Support\Collection getProductCategoriesWithIndent(string $indent = '&nbsp;&nbsp;', bool $sortChildren = true)
 * @method static array getProductCategoriesWithIndentName(\Illuminate\Support\Collection|array $categories = [], string $indent = '&nbsp;&nbsp;')
 * @method static bool appendIndentTextToProductCategoryName(\Illuminate\Support\Collection $categories, int $depth = 0, array $results = [], string $indent = '&nbsp;&nbsp;')
 * @method static \Illuminate\Support\Collection getActiveTreeCategories()
 *
 * @see \Botble\Ecommerce\Supports\ProductCategoryHelper
 */
class ProductCategoryHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseProductCategoryHelper::class;
    }
}
