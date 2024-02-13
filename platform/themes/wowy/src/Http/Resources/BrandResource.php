<?php

namespace Theme\Wowy\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use RvMedia;

class BrandResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'website' => $this->website,
            'logo' => RvMedia::getImageUrl($this->logo, null, false, RvMedia::getDefaultImage()),
        ];
    }
}
