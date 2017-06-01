<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Api\Transform\UserTransform;

/**
 * @Resource("User", uri="/auth")
 */
class AuthController extends BaseController
{
    /**
     * Get the auth code.
     *
     * Get a auth code.
     *
     * @Get("/login")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"phone": "your phone number", "password": "your password"}),
     *      @Response(200, body={"token": "your token"}),
     * })
     *
     * @param \Illuminate\Http\Request $request
     * @return json
     */
    public function authentication(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->error('invalid_credentials', 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->response->error('could_not_create_token', 500);
        }
        // all good so return the token
        $data = [
            'data' => [
                'token' => $token
            ]
        ];
        return $this->response->array($data);
    }

    /**
     * Get authed user.
     *
     * Get authed user info.
     *
     * @Get("/user")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "your token"}),
     *      @Response(200, body={"data": {}}),
     *      @Response(500, body={"message": "boo", "status_code": 500})
     * })
     *
     * @param \Illuminate\Http\Request $request
     * @return json
     */
    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->response->errorNotFound('user_not_found');
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return $this->response->error('token_expired', $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return $this->response->error('token_invalid', $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return $this->response->error('token_absent', $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return $this->response
                    ->item($user, new UserTransform)
                    ->setStatusCode(200);
    }
}
