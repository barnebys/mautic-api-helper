<?php

namespace BarnebysMautic;

use BarnebysMautic\Exception\AuthInstanceException;
use Mautic\Auth\ApiAuth;
use Mautic\Auth\AuthInterface;

class Auth
{

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @return self
     *
     * @throws AuthInstanceException
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            throw new AuthInstanceException();
        }

        return self::$instance;
    }

    /**
     * @param string $username
     * @param string $password
     */
    public static function initializeHttpBasic($username, $password)
    {
        $auth = (new ApiAuth())->newAuth([
            'userName'   => $username,
            'password'   => $password
        ], 'BasicAuth');


        self::$instance = new self();
        self::$instance->setMauticAuth($auth);
    }

    /**
     * @param string $baseUrl
     * @param string $clientKey
     * @param string $clientSecret
     * @param string $callback
     */
    public static function initializeOAuth2($baseUrl, $clientKey, $clientSecret, $callback)
    {
        $auth = (new ApiAuth())->newAuth([
            'baseUrl'          => $baseUrl,
            'version'          => 'OAuth2',
            'clientKey'        => $clientKey,
            'clientSecret'     => $clientSecret,
            'callback'         => $callback
        ], 'OAuth');

        self::$instance = new self();
        self::$instance->setMauticAuth($auth);
    }

    /**
     * @var AuthInterface
     */
    private $mauticAuthInstance;

    /**
     * @param AuthInterface $auth
     */
    public function setMauticAuth(AuthInterface $auth)
    {
        $this->mauticAuthInstance = $auth;
    }

    /**
     * @return AuthInterface
     */
    public function getMauticAuth()
    {
        return $this->mauticAuthInstance;
    }

}
