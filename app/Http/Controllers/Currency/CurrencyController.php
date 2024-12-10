<?php

namespace App\Http\Controllers\Currency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Mgcodeur\CurrencyConverter\Facades\CurrencyConverter;
class CurrencyController extends Controller
{
    public function index()
    {
            $currencies = CurrencyConverter::currencies()->get();
            return responseApi(200, 'OK', $currencies);
    }

    public function convert(Request $request){
// Validate input parameters
        $request->validate([
            'currency_from' => 'required|string',
            'currency_to' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $from = $request->query('currency_from');
        $to = $request->query('currency_to');
        $amount = $request->query('amount');

        try {
            $convertedAmount = CurrencyConverter::convert($amount)
            ->from($from)
            ->to($to)
            ->get();

            if (empty($convertedAmount)) {
                return response()->json(['status' => 404, 'message' => 'No conversion data found.'], 404);
            }
            
            return responseApi(200, 'OK', $convertedAmount);
            } catch (\Exception $e) {
            return responseApi(500, 'Error occurred: ' . $e->getMessage());
        }
    }
}
