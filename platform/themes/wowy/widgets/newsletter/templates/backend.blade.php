<div class="form-group mb-3">
    <label for="widget-name">{{ trans('core/base::forms.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ $config['subtitle'] }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>
