<?php

use Botble\Widget\AbstractWidget;

class NewsletterWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Newsletter'),
            'subtitle' => __('Subtitle'),
            'description' => __('Widget description'),
        ]);
    }
}
