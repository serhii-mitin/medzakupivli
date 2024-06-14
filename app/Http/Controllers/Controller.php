<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "api", title: "Api Documentation"),
    OA\Server(url: 'http://localhost:8080', description: "Local server"),
    OA\SecurityScheme(
        securityScheme: "Bearer",
        type: "apiKey",
        name: "Authorization",
        in: "header",
    )
]
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
