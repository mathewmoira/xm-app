<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Tests\TestCase;

class HistoricalDataViewTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_view_displays_historical_data()
    {
        // Simulate data to pass to the view
        $symbol = 'AAPL';
        $startDate = '2023-01-01';
        $endDate = '2023-01-10';
        $historicalData = [
            // Define your historical data here as an array of data points
            // Example: ['date' => '2023-01-01', 'open' => 150.0, 'high' => 155.0, ...],
        ];
        
        // Call the view and check if it displays the provided data
        $response = $this->view('historical-data', compact('symbol', 'startDate', 'endDate', 'historicalData'));
        
        $response->assertSeeText('Historical Data for AAPL');
        $response->assertSeeText('From 2023-01-01 to 2023-01-10');
        
        // You should also assert that the data in $historicalData is displayed correctly in the table
        foreach ($historicalData as $dataPoint) {
            $response->assertSeeText($dataPoint['date']);
            $response->assertSeeText($dataPoint['open']);
            $response->assertSeeText($dataPoint['high']);
            $response->assertSeeText($dataPoint['low']);
            $response->assertSeeText($dataPoint['close']);
            $response->assertSeeText($dataPoint['volume']);
        }
    }
    
    public function test_view_displays_no_data_message()
    {
        // Simulate data to pass to the view (empty historicalData)
        $symbol = 'AAPL';
        $startDate = '2023-01-01';
        $endDate = '2023-01-10';
        $historicalData = [];
        
        // Call the view and check if it displays a message for no data
        $response = $this->view('historical-data', compact('symbol', 'startDate', 'endDate', 'historicalData'));
        
        $response->assertSeeText('Historical Data for AAPL');
        $response->assertSeeText('From 2023-01-01 to 2023-01-10');
        $response->assertSeeText('No historical data available.');
    }
    
    public function test_view_displays_chart_script()
    {
        // Simulate data to pass to the view (you can provide sample data for your chart)
        $symbol = 'AAPL';
        $startDate = '2023-01-01';
        $endDate = '2023-01-10';
        $historicalData = [];
        $openPrices = [];
        $closePrices = [];
        
        // Call the view and check if it displays the chart script
        $response = $this->view('historical-data', compact('symbol', 'startDate', 'endDate', 'historicalData', 'openPrices', 'closePrices'));
        
        $response->assertSeeText('var ctx = document.getElementById(\'priceChart\').getContext(\'2d\');');
        $response->assertSeeText('new Chart(ctx, {');
        $response->assertSeeText('type: \'line\',');
        // ... (assert other parts of your chart script)
    }
}
