<?php
namespace App\Client;

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/13/2017
 * Time: 8:03 PM
 */
class LoginClient extends BaseClient
{
    public function getToken($grantType, $email, $password)
    {
        $data = [
            'grant_type' => $grantType,
            'username' => $email,
            'password' => $password,
            'scope' => '*',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET')
        ];
        $response = $this->postRequest('oauth/token', $data);
        return $this->generateReponse($response);
    }

}