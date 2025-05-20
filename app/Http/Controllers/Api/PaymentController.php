<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\Reservation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentRequest;
use App\Interfaces\PaymentRepositoryInterface;

class PaymentController extends Controller
{
    use ApiResponse;
    private $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function processPayment(PaymentRequest $request, $reservation_id)
    {
        $payment = $this->paymentRepository->processPayment([
            'reservation_id' => $reservation_id,
            'payment_option' => $request->payment_option,
        ]);
        $invoice = $this->paymentRepository->generateInvoice([
            'payment_id' => $payment->id,
            'reservation_id' => $payment->reservation_id,
            'amount' => $payment->amount,
            'tax' => $payment->tax,
            'service_charge' => $payment->service_charge,
            'total_amount' => $payment->total_amount,
            'payment_option' => $payment->payment_option,
        ]);
        $response = [];
        $response['payment'] = $payment;
        $response['invoice'] = $invoice;
        return $this->successResponse(200, 'Payment processed successfully', $response);
    }
}
