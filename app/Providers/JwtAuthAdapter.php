<?php

namespace App\Providers;

use Tymon\JWTAuth\Providers\Auth\AuthInterface;
use Auth;

class JwtAuthAdapter implements AuthInterface
{
    /**
     * @var \Auth
     */
    protected $auth;

    /**
     * @param \Auth  $auth
     */
    public function __construct()
    {
        $this->auth = Auth::user();
    }

    /**
     * Check a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function byCredentials(array $credentials = [])
    {
        return $this->auth->once($credentials);
    }

    /**
     * Authenticate a user via the id.
     *
     * @param  mixed  $id
     * @return bool
     */
    public function byId($id)
    {
        return $this->auth->onceUsingId($id);
    }

    /**
     * Get the currently authenticated user.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->auth->user();
    }
}
