<?php

declare(strict_types=1);

namespace App\Services\Payment\Gateways;

use App\Models\Payment;

interface PaymentGatewayInterface
{
    /**
     * Charge the payment and return the gateway response.
     *
     * @return array{
     *     transaction_id?: string,
     *     payment_url?: string,
     *     qr_code_url?: string,
     *     status: string
     * }
     */
    public function charge(Payment $payment): array;
}
