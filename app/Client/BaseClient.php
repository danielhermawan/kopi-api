<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/13/2017
 * Time: 10:05 PM
 */

namespace App\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class BaseClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * LoginClient constructor.
     */
    public function __construct()
    {
        $this->client = resolve('InternalClient');
    }

    public function generateReponse(ResponseInterface $response)
    {
        return [
            'body' => json_decode($response->getBody()),
            'status' => $response->getStatusCode()
        ];
    }

    public function postRequest($uri, $data): ResponseInterface
    {
        return $this->client->request('POST', $uri, [
            'form_params' => $data
        ]);
    }
}