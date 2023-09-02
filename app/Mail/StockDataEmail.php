<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockDataEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $startDate;
    public $endDate;
    public $companyName;

    public function __construct($companyName, $startDate, $endDate)
    {
        $this->companyName = $companyName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this
            ->subject($this->companyName)
            ->markdown('emails.stock_data'); // Create a Blade view for email content
    }
}
