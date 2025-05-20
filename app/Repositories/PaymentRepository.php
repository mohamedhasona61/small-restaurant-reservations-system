<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function processPayment(array $paymentDetails)
    {
        $reservation = Reservation::findOrFail($paymentDetails['reservation_id']);
        if ($paymentDetails['payment_option'] === 'option1') {
            $tax = $reservation->total_amount * 0.14;
            $serviceCharge = $reservation->total_amount * 0.20;
            $totalAmount = $reservation->total_amount + $tax + $serviceCharge;
        } else {
            $tax = 0;
            $serviceCharge = $reservation->total_amount * 0.15;
            $totalAmount = $reservation->total_amount + $serviceCharge;
        }
        return Payment::create([
            'reservation_id' => $reservation->id,
            'payment_option' => $paymentDetails['payment_option'],
            'amount' => $reservation->total_amount,
            'tax' => $tax,
            'service_charge' => $serviceCharge,
            'total_amount' => $totalAmount,
        ]);
    }

    public function generateInvoice(array $invoiceDetails)
    {
        return [
            'invoice_number' => 'INV-' . str_pad($invoiceDetails['payment_id'], 6, '0', STR_PAD_LEFT),
            'date' => now()->format('Y-m-d'),
            'reservation_id' => $invoiceDetails['reservation_id'],
            'subtotal' => $invoiceDetails['amount'],
            'tax' => $invoiceDetails['tax'],
            'service_charge' => $invoiceDetails['service_charge'],
            'total' => $invoiceDetails['total_amount'],
            'payment_option' => $invoiceDetails['payment_option'],
        ];
    }
}
