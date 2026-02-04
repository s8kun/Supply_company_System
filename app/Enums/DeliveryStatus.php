<?php

namespace App\Enums;

enum DeliveryStatus: string
{
    case PENDING = 'pending';
    case PARTIALLY_DELIVERED = 'partially_delivered';
    case FULLY_DELIVERED = 'fully_delivered';
}
