<?php

declare(strict_types=1);

namespace App\Core\Enums;

// If class_alias is desired, we can alias App\Domains\Order\Enums\OrderStatusEnum
if (!class_exists('App\Core\Enums\OrderStatusEnum', false)) {
    class_alias(\App\Domains\Order\Enums\OrderStatusEnum::class, 'App\Core\Enums\OrderStatusEnum');
}
