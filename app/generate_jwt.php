<?php

declare(strict_types=1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

require_once('vendor/autoload.php');

class JWTGenerate
{
    public $secret_key;
    public $payload;
    public $domainName;
    public $date;
    public $expire_at;

    public function __construct()
    {
        $this->secret_key  = '68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=';
        $this->date   = new DateTimeImmutable();
        $this->expire_at     = $this->date->modify('+6 minutes')->getTimestamp();      // Add 60 seconds
        $this->domainName = URLROOT;
    }

    public function generate()
    {
        $this->payload = [
            'iat'  => $this->date->getTimestamp(),         // Issued at: time when the token was generated
            'iss'  => $this->domainName,                       // Issuer
            'nbf'  => $this->date->getTimestamp(),         // Not before
            'exp'  => $this->expire_at,                           // Expire
        ];

        return JWT::encode($this->payload, $this->secret_key, 'HS512');
    }

    public static function getToken()
    {
        if (isset($_COOKIE["jwt"])) {
            if ($_COOKIE["jwt"] === "" || $_COOKIE["jwt"] === null || $_COOKIE["jwt"] === 0 || $_COOKIE["jwt"] === false) {
                // echo $_COOKIE["jwt"];
                echo 'Login to authenticate';
                exit;
            } else {
                // echo $_COOKIE["jwt"];
                return $_COOKIE["jwt"];
            }
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Token not found in request';
            exit;
        }
    }

    public static function validate()
    {
        if (!$tokenInCookie = JWTGenerate::getToken()) {
            echo "Token not found";
            exit();
        };
    }
}
