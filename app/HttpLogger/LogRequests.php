<?php

declare(strict_types=1);

namespace App\HttpLogger;

use Illuminate\Http\Request;
use Spatie\HttpLogger\LogProfile;

class LogRequests implements LogProfile
{
    public function shouldLogRequest(Request $request) : bool
    {
        return true;
    }
}
