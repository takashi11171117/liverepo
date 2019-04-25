<?php
namespace App\Http;

class Request extends \Illuminate\Http\Request
{
    /**
     * override
     */
    public function expectsJson()
    {
        return true;
    }

    /**
     * override
     */
    public function wantsJson()
    {
        return true;
    }
}