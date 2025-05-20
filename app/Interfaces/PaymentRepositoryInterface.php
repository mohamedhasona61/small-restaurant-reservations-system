<?php

namespace App\Interfaces;

interface PaymentRepositoryInterface
{
    public function processPayment(array $paymentDetails);
    public function generateInvoice(array $invoiceDetails);
}
