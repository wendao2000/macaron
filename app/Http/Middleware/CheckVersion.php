<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckVersion
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $version = '';

        // Web API Versioning
        if ($request->hasHeader('API-Version')) {
            $version = $request->header('API-Version');
        }

        // Android APK Versioning
        elseif ($request->hasHeader('APK-Version')) {
            foreach (config('version.android') as $k => $v) {
                if ($k <= $request->header('APK-Version')) {
                    $version = $v;
                    break;
                }
            }
        }

        // iOS IPA Versioning
        elseif ($request->hasHeader('IPA-Version')) {
            foreach (config('version.ios') as $k => $v) {
                if ($k <= $request->header('IPA-Version')) {
                    $version = $v;
                    break;
                }
            }
        }

        if (!in_array($version, config('version'))) {
            return response()->json([
                'status' => false,
                'message' => config('error.VERSION.00'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $request->request->add(['version' => $version]);

        return $next($request);
    }
}
