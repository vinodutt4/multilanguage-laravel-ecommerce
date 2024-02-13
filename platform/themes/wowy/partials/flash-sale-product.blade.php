<div class="deal wow fadeIn animated mb-md-4 mb-sm-4 mb-lg-0" style="background-image: url({{ RvMedia::getImageUrl($flashSale->getMetaData('image', true), null, false, RvMedia::getDefaultImage()) }});">
    <div class="deal-top">
        <h2 class="text-brand">{{ $flashSale->name }}</h2>
        <h5>{!! BaseHelper::clean($flashSale->getMetaData('subtitle', true)) !!}</h5>
    </div>
    <div class="deal-content">
        @if (EcommerceHelper::isReviewEnabled())
            <h6 class="product-title mb-0"><a href="{{ $product->url }}">{{ $product->name }}</a></h6>
            <div class="rating_wrap mb-20">
                <div class="rating">
                    <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                </div>
                <span class="rating_num">({{ $product->reviews_count }})</span>
            </div>
        @else
            <h6 class="product-title"><a href="{{ $product->url }}">{{ $product->name }}</a></h6>
        @endif

        <div class="product-price"><span class="new-price">{{ format_price($product->front_sale_price_with_taxes) }}</span>
            @if ($product->front_sale_price !== $product->price)
                <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
            @endif
        </div>
    </div>
    <div class="deal-bottom">
        <p>{{ __('Hurry Up! Offer End In:') }}</p>
        <div class="deals-countdown" data-countdown="{{ $flashSale->end_date }}"></div>
        <a href="{{ $product->url }}" class="btn hover-up">{{ __('Shop Now') }} <i class="fa fa-arrow-right"></i></a>
    </div>
</div>
