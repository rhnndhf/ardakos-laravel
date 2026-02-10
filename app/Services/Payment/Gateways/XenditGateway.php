<?php

declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Models\Payment;
use App\Models\PaymentMethod;

class XenditGateway implements PaymentGatewayInterface
{
    public function __construct(protected PaymentMethod $method)
    {
    }

    public function charge(Payment $payment): array
    {
        // Integration with Xendit API would go here

        return [
            'status' => 'Pending',
            'payment_url' => 'https://checkout-staging.xendit.co/web/' . uniqid(),
            'transaction_id' => 'XND-' . uniqid(),
        ];
    }
}
