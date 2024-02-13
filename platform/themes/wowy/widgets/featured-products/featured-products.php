<?php

use Botble\Widget\AbstractWidget;

class FeaturedProductsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('FeaturedProducts'),
            'description' => __('Widget display featured products'),
            'number_display' => 3,
        ]);
    }
}
