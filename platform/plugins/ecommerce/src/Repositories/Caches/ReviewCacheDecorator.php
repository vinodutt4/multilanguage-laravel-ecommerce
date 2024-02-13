<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Ecommerce\Repositories\Interfaces\ReviewInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Illuminate\Database\Eloquent\Collection;

class ReviewCacheDecorator extends CacheAbstractDecorator implements ReviewInterface
{
    public function getGroupedByProductId(int|string $productId): Collection
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
