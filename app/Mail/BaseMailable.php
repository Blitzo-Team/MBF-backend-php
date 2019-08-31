<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class BaseMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $base_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

}