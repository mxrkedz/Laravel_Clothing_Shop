<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\PDF;
use Illuminate\Mail\Markdown;

class OrderConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $order;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userEmail, $order)
    {
        $this->email = $userEmail;
        $this->order = $order;
    }

    public function build()
    {

        // var_dump(app(PDF::class));

        $pdf = app(PDF::class);
        $view = view('pdf.order', ['order' => $this->order]);


        $pdf->loadHTML($view->render());
        $pdf->setOptions(['defaultFont' => 'Arial']);

        $pdfData = $pdf->output();

        return $this->to($this->email)
            ->view('email.order-confirmation')
            ->with(['order' => $this->order])
            ->attachData($pdfData, 'receipt.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Order Confirmation',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.order-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
