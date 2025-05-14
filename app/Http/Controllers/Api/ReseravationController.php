<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Exceptions\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReservationRequest;
use App\Interfaces\ReservationRepositoryInterface;

class ReseravationController extends Controller
{
    use ApiResponse;
    private ReservationRepositoryInterface $reservationRepo;
    public function __construct(ReservationRepositoryInterface $reservationRepo)
    {
        $this->reservationRepo = $reservationRepo;
    }
    public function createOrder(ReservationRequest $request)
    {
        try {
            $reservation = $this->reservationRepo->createReservation($request->validated());
            return $this->successResponse(201, 'Reservation created successfully', $reservation);
        } catch (\Exception $e) {
            return ExceptionHandler::handle($e, request(), $e->getMessage());
        }
    }
}
