<?php

declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Models\Payment;
use App\Models\PaymentMethod;

class ManualGateway implements PaymentGatewayInterface
{
    public function __construct(protected PaymentMethod $method)
    {
    }

    public function charge(Payment $payment): array
    {
        // For manual payments, we just return a success/pending status
        // and instructions (e.g. bank account number from config)

        return [
            'status' => 'Pending',
            'payment_url' => null, // Or a url to a page with instructions
        ];
    }
}
