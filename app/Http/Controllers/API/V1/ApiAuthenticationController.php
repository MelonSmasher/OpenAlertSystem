<?php

namespace App\Http\Controllers\API\V1;

use Dingo\Api\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiAuthenticationController extends BaseAPIController
{

    /**
     * ApiAuthenticationController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Login with an API key secret
     *
     * Endpoint for api secret to be posted. Returns a JWT.
     *
     * @return array
     */
    public function authenticate(Request $request)
    {
        $secret = Input::only('secret');
        try {
            $user = User::where('api_secret', strtoupper($secret['secret']))->first();
            if (!$user) {
                throw new UnauthorizedHttpException('Invalid credentials were supplied.');
            }
            if (!$token = JWTAuth::fromUser($user)) {
                throw new UnauthorizedHttpException('Invalid credentials were supplied.');
            }
        } catch (JWTException $e) {
            throw new HttpException('Could not create new token.', $e);
        }
        // Return success.
        return compact('token');

    }

    /**
     * Validate Session
     *
     * Validate JWT by hitting this end point.
     *
     * @param Request $request
     * @return mixed
     */
    public function validateAuth(Request $request)
    {
        $user = auth()->user();

        if (!$user) throw new UnauthorizedHttpException('You are not authorized.');

        return $this->response->array([
            'user' => $user->email,
            'message' => 'success',
            'status_code' => 202
        ])->setStatusCode(202);
    }
}
