<?php

namespace App\Enums;

enum PaymentTypes: int
{
    case CREDIT_CARD = 0;
    case DEBIT_CARD = 1;
    case PAYPAL = 2;
    case BANK_SLIP = 3;
    case PIX = 4;
}