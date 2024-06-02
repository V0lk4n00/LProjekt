<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUploadSize
{
    // Check if the file size exceeds 300MB, if so - redirect to the default converter page
    // This function generates PHP warning due to the "post_max_size = 300M" & "upload_max_filesize" = 300M in php.ini
    // "display_errors" in php.ini had to be set to "Off"
    public function handle(Request $request, Closure $next): Response
    {
        $max_file_size = 300 * 1024 * 1024;

        $contentLength = $request->header('Content-Length');

        if ($contentLength && $contentLength > $max_file_size) {
            return redirect()->back();
        }

        return $next($request);
    }
}
