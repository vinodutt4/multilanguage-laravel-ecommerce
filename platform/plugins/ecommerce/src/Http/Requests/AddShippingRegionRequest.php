<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Support\Http\Requests\Request;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Validation\Rule;

class AddShippingRegionRequest extends Request
{
    public function rules(): array
    {
        return [
            'region' => ['required', 'string', Rule::in(array_keys(EcommerceHelper::getAvailableCountries()))],
        ];
    }
}
