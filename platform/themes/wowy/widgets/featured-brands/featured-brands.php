<?php

use Botble\Widget\AbstractWidget;

class FeaturedBrandsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('FeaturedBrands'),
            'description' => __('Widget display featured brands'),
            'number_display' => 10,
        ]);
    }
}
