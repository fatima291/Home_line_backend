<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class AdminCustomerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Customer::orderBy('created_at', 'desc')->get());
    }
}