<?php

namespace App\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    public function response(
        $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $data = [
            'success' => true,
            'data'    => $data
        ];

        return response()
                ->json($data, $status, $headers, $options);
    }

    // public function errorResponse(
    //     $data = [], int $status = 500, array $headers = [], $options = 0)
    // {
    //     $data = [
    //         'success' => true,
    //         'data'    => $data
    //     ];

    //     return response()
    //             ->json($data, $status, $headers, $options);
    // }
}
