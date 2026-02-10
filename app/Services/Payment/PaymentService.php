<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PaymentService
{
    /**
     * Process a payment for a transaction.
     */
    public function processPayment(Transaction $transaction, PaymentMethod $method): Payment
    {
        // 1. Validate payment method belongs to the same landlord
        if ($transaction->landlord_id !== $method->landlord_id) {
            throw new InvalidArgumentException('Payment method does not belong to the transaction landlord.');
        }

        // 2. Create Payment record
        $payment = DB::transaction(function () use ($transaction, $method) {
            return Payment::create([
                'landlord_id' => $transaction->landlord_id,
                'tenant_id' => $transaction->tenant_id,
                'transaction_id' => $transaction->id,
                'payment_method_id' => $method->id,
                'payment_type' => 'Monthly Rent', // Should be dynamic based on transaction type mapping
                'amount' => $transaction->amount,
                'currency' => 'IDR',
                'status' => 'Pending',
            ]);
        });

        // 3. Initiate Gateway Processing (Strategy Pattern)
        $gateway = PaymentGatewayFactory::create($method);
        $response = $gateway->charge($payment);

        // 4. Update Payment with Gateway Response
        $payment->update([
            'gateway_transaction_id' => $response['transaction_id'] ?? null,
            'gateway_payment_url' => $response['payment_url'] ?? null,
            'qr_code_url' => $response['qr_code_url'] ?? null,
            'status' => $response['status'] ?? 'Pending',
        ]);

        return $payment;
    }
}
