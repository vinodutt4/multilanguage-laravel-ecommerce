<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Base\Facades\BaseHelper;
use Botble\Support\Http\Requests\Request;

class UpdateSettingsRequest extends Request
{
    public function rules(): array
    {
        return [
            'store_name' => 'required|string',
            'store_address' => 'required|string',
            'store_phone' => 'required|' . BaseHelper::getPhoneValidationRule(),
            'store_state' => 'nullable|string',
            'store_city' => 'nullable|string',
        ];
    }
}
