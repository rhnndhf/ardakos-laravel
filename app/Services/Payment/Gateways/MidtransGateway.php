<?php

declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Models\Payment;
use App\Models\PaymentMethod;

class MidtransGateway implements PaymentGatewayInterface
{
    public function __construct(protected PaymentMethod $method)
    {
    }

    public function charge(Payment $payment): array
    {
        // Integration with Midtrans Snap API would go here
        // Using credentials from $this->method->api_key (encrypted)

        return [
            'status' => 'Pending',
            'payment_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . uniqid(),
            'transaction_id' => 'MID-' . uniqid(),
        ];
    }
}
