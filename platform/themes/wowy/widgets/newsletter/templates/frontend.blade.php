@if (is_plugin_active('newsletter'))
    {!! do_shortcode('[newsletter-form title="' . BaseHelper::clean(__($config['name'])) . '" description="' . BaseHelper::clean(__($config['subtitle'])) . '"][/newsletter-form]') !!}
@endif
