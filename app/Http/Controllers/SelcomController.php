<?php

namespace App\Http\Controllers;

use Selcom\ApigwClient\Client;

class SelcomController extends Controller
{
    public function createOrder()
    {
        $selcom = new Client(
            env('SELCOM_BASE_URL'),
            env('SELCOM_API_KEY'),
            env('SELCOM_API_SECRET')
        );

        $data = [
            "order_id" => "ORDER12345",
            "amount"   => 1000,
            "currency" => "TZS",
            "customer_id" => "255712345678"
        ];

        $response = $selcom->postFunc("/create-order-minimal", $data);

        dd($response);


        return response()->json($response);
    }
}
