<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FormController extends Controller
{
    public function showForm()
    {
        // Fetch company symbols from the JSON data source
        $companySymbols = $this->fetchCompanySymbols();

        return view('form', compact('companySymbols'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'companySymbol' => 'required|exists:company_symbols', 
            'startDate' => 'required|date|before_or_equal:endDate|before_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate|before_or_equal:today',
            'email' => 'required|email',
        ]);

        // If validation passes, proceed to process the form data
    }

    // Implement a method to fetch company symbols from JSON source
    private function fetchCompanySymbols()
    {
        $response = \Http::get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');
        $data = $response->json();

        // Extract company symbols from the JSON data
        $companySymbols = collect($data)
            ->pluck('Symbol')
            ->unique()
            ->values()
            ->toArray();

        return $companySymbols;
    }
    
    public function getHistoricalData(Request $request)
    {
        // Retrieve the symbol, start date, and end date from the submitted form
        $symbol = $request->input('companySymbol');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Make an API request to retrieve historical data
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => '52ed3a562dmshf1ab03151ca598ap16fcbejsnceb5e49de92b',
            'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
        ])->get('https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data', [
            'symbol' => $symbol,
            'region' => 'US', // You can make this dynamic if needed
        ]);
    
        // Check if the request was successful
        if ($response->successful()) {
            $apiData = $response->json();
            $historicalData = [];
    
            // Check if 'prices' is an array and not empty
        if (isset($apiData['prices']) && is_array($apiData['prices']) && !empty($apiData['prices'])) {
            foreach ($apiData['prices'] as $apiItem) {
                $historicalData[] = [
                    'date' => $apiItem['date'],
                    'open' => isset($apiItem['open']) ? $apiItem['open'] : null,
                    'high' => isset($apiItem['high']) ? $apiItem['high'] : null,
                    'low' => isset($apiItem['low']) ? $apiItem['low'] : null,
                    'close' => isset($apiItem['close']) ? $apiItem['close'] : null,
                    'volume' => isset($apiItem['volume']) ? $apiItem['volume'] : null,
                ];
            }

            // Extract Open and Close prices
            $openPrices = array_column($historicalData, 'open');
            $closePrices = array_column($historicalData, 'close');

            // Process and display the transformed historical data in a view
            return view('historical-data', [
                'symbol' => $symbol,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'historicalData' => $historicalData,
                'openPrices' => $openPrices, // Pass Open prices to the view
                'closePrices' => $closePrices, // Pass Close prices to the view
            ]);
        } else {
            // Handle the case where the API response data is not an array
            return redirect()->back()->with('error', 'Historical Data is unavailable.');
        }

        // Send an email with the retrieved data
        Mail::to($email)
            ->send(new StockDataEmail($symbol, $startDate, $endDate));

        // Optionally, you can check if the email was sent successfully
        if (Mail::failures()) {
            // Handle the case where the email failed to send
        } 
        
    } else {
        // Handle the case where the API request failed (e.g., show an error message)
        return redirect()->back()->with('error', 'Failed to fetch historical data.');
    }
}
    
    

}

