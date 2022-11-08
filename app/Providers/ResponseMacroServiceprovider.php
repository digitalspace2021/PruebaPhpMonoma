<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceprovider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data, $status_code) {
            return response()->json([
                "meta" => [
                    'success' => true
                ],
                "data" => $data
            ], $status_code);
        });

        Response::macro('error', function ($data, $status_code) {
            return response()->json([
                'meta'=>[
                    'success' => false,
                    'errors'=>$data
                ],
            ], $status_code);
        });
    }
}
