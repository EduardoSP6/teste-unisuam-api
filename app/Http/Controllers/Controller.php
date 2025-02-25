<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="UNISUAM API",
 *      description="UNISUAM API to manage Github Users.",
 *      @OA\Contact(
 *          email="eduardo.sp6@gmail.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     name="Authorization",
 *     description="Paste the token without 'Bearer'",
 *     in="header",
 *     type="http",
 *     scheme="bearer",
 * )
 *
 * @OA\Get(
 *     path="/api/status",
 *     tags={"ApiStatus"},
 *     summary="Get API status",
 *     description="Api status info",
 *     @OA\Response(response="default", description="Status response")
 * )
 */
abstract class Controller
{
    //
}
