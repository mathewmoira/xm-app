<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormViewTest extends TestCase
{
    /** @test */
    public function it_displays_the_form_correctly()
    {
        $response = $this->get('/form'); 

        $response->assertStatus(200); // Check that the response status is OK (200).
        $response->assertViewIs('form'); // Check that the correct view is being used (replace 'form' with your actual view name).
        
        // Check that form elements are present
        $response->assertSee('Company Symbol');
        $response->assertSee('Start Date (YYYY-mm-dd)');
        $response->assertSee('End Date (YYYY-mm-dd)');
        $response->assertSee('Email');
        $response->assertSee('Submit');

    }

    /** @test */
    public function it_shows_errors_correctly()
    {
        // Simulate a request with validation errors
        $response = $this->post('/form', []); 

        $response->assertStatus(302); // Check that the response is a redirect (usually after validation fails).
        $response->assertSessionHasErrors(['companySymbol', 'startDate', 'endDate', 'email']); // Check for validation errors.
        
        // Check that error messages are displayed in the response
        $response->assertSee('The companySymbol field is required.');
        $response->assertSee('The startDate field is required.');
        $response->assertSee('The endDate field is required.');
        $response->assertSee('The email field is required.');

    }
}
