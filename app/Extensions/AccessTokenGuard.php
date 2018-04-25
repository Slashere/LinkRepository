<?php

namespace App\Extensions;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;

    private $inputKey = 'access_token';
    private $storageKey = 'access_token';
    private $request;

    public function __construct (UserProvider $provider, Request $request, $configuration) {
        $this->provider = $provider;
        $this->request = $request;
        // key to check in request
        $this->inputKey =  'access_token';
        // key to check in database
        $this->storageKey = 'access_token';
    }


    public function user () {
        if (!is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        // retrieve via token
        $token = $this->getTokenForRequest();
        if (! empty($token)) {
            $user = $this->provider->retrieveByToken($this->storageKey, $token);
        }
        return $this->user = $user;
    }
    /**
     * Get the token for the current request.
     * @return string
     */
    public function getTokenForRequest () {
        $token = $this->request->query($this->inputKey);
        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }
        if (empty($token)) {
            $token = $this->request->bearerToken();
        }
        return $token;
    }
    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     *
     * @return bool
     */
    public function validate (array $credentials = []) {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }
        $credentials = [ $this->storageKey => $credentials[$this->inputKey] ];
        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }
        return false;
    }
}