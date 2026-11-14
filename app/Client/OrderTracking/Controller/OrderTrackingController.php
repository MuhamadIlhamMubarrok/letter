<?php

declare(strict_types=1);

namespace App\Client\OrderTracking\Controller;

use App\Domains\Order\Controllers\OrderTrackingController as DomainOrderTrackingController;

/**
 * Class OrderTrackingController
 * Backward-compatibility wrapper pointing to App\Domains\Order\Controllers\OrderTrackingController
 */
class OrderTrackingController extends DomainOrderTrackingController
{
}
