<x-core-setting::section
    :title="trans('plugins/analytics::analytics.settings.title')"
    :description="trans('plugins/analytics::analytics.settings.description')"
>
    <x-core-setting::text-input
        name="google_analytics"
        :label="trans('plugins/analytics::analytics.settings.tracking_code')"
        :value="setting('google_analytics')"
        :placeholder="trans('plugins/analytics::analytics.settings.tracking_code_placeholder')"
        helper-text="<a href='https://support.google.com/analytics/answer/9539598#find-G-ID' target='_blank'>https://support.google.com/analytics/answer/9539598#find-G-ID</a>"
        data-counter="120"
    />

    <x-core-setting::radio
        name="analytics_type"
        :label="trans('plugins/analytics::analytics.settings.type')"
        :options="[
                'ua' => trans('plugins/analytics::analytics.settings.ua_description'),
                'ga4' => trans('plugins/analytics::analytics.settings.ga4_description'),
            ]"
        :value="setting('analytics_type', 'ua')"
    />

    <x-core-setting::text-input
        name="analytics_view_id"
        :label="trans('plugins/analytics::analytics.settings.view_id')"
        :value="setting('analytics_view_id')"
        :placeholder="trans('plugins/analytics::analytics.settings.view_id_description')"
        data-counter="120"
    />

    <x-core-setting::text-input
        name="analytics_property_id"
        :label="trans('plugins/analytics::analytics.settings.analytics_property_id')"
        :value="setting('analytics_property_id')"
        :placeholder="trans('plugins/analytics::analytics.settings.analytics_property_id_description')"
        data-counter="120"
    />

    @if (! app()->environment('demo'))
        <x-core-setting::form-group>
            <label class="text-title-field" for="analytics_service_account_credentials">{{ trans('plugins/analytics::analytics.settings.json_credential') }}</label>
            <textarea class="next-input form-control" name="analytics_service_account_credentials" id="analytics_service_account_credentials" rows="5" placeholder="{{ trans('plugins/analytics::analytics.settings.json_credential_description') }}">{{ setting('analytics_service_account_credentials') }}</textarea>
        </x-core-setting::form-group>
    @endif
</x-core-setting::section>
