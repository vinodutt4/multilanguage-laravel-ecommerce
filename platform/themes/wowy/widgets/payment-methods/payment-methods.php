<?php

use Botble\Widget\AbstractWidget;

class PaymentMethodsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Payments'),
            'description' => __('Widget display accepted payment methods.'),
            'image' => null,
        ]);
    }
}
