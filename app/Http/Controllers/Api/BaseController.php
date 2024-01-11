<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Server(url="http://localhost/api/v1")
 *
 * @OA\Info(
 *    title="Sms Api Documentation",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Schema (
 *     schema="UnAuthorized",
 *     title="UnAuthorized",
 *     @OA\Property(property="message", type="string",description="UnAuthorized Message"),
 * )
 * @OA\Schema (
 *     schema="ApiResponse",
 *     title="ApiResponse",
 *     @OA\Property(property="status", type="boolean",description="Status"),
 *     @OA\Property(property="message", type="string",description="Message"),
 *     @OA\Property(property="data", type="object",description="Data"),
 * )
 *
 *
 *
 */
class BaseController extends Controller
{

}
