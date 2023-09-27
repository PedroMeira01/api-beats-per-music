<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING_PAYMENT = 0;
    case AWAITING_PROCESSING = 1;
    case PROCESSING = 2;
    case SHIPPED = 3;
    case DELIVERED = 4;
    case CANCELED = 5;
    case REFUNDED = 6;
    case ON_HOLD = 7;
    case DELAYED = 8;
    case RETURNED = 9;
    case UNDER_REVIEW = 10;
    case CUSTOM_ORDER = 11;
}