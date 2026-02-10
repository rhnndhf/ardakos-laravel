<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\PaymentMethod;
use App\Services\Payment\Gateways\ManualGateway;
use App\Services\Payment\Gateways\MidtransGateway;
use App\Services\Payment\Gateways\PaymentGatewayInterface;
use App\Services\Payment\Gateways\XenditGateway;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    public static function create(PaymentMethod $method): PaymentGatewayInterface
    {
        return match ($method->gateway_type) {
            'Midtrans' => new MidtransGateway($method),
            'Xendit' => new XenditGateway($method),
            'Manual', 'BankTransfer' => new ManualGateway($method),
            default => throw new InvalidArgumentException("Unsupported gateway type: {$method->gateway_type}"),
        };
    }
}
