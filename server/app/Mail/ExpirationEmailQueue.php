<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpirationEmailQueue extends Mailable
{
    use Queueable, SerializesModels;

    protected $productName;
    protected $inventoryName;
    protected $expiration;
    protected $username;
    /**
     * 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productName,$username,$expirationDate,$inventoryName)
    {
        $this->productName = $productName;
        $this->inventoryName = $inventoryName;
        $this->expiration = $expirationDate;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A product is reaching its expiration date')
                ->view('emails.expiration')
                ->with([
                    'product'=>$this->productName,
                    'inventory'=>$this->inventoryName,
                    'expiration'=>$this->expiration,
                    'username' =>$this->username
                ]);
    }
}
