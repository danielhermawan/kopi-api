<?php

namespace App\Http\Controllers;

use App\Client\LoginClient;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $repository;
    private $client;

    /**
     * LoginController constructor.
     */
    public function __construct(LoginClient $loginClient, UserRepository $repository)
    {
        $this->client = $loginClient;
        $this->repository = $repository;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->repository->getWhere('username', $request->input('username'), true);
        $response = $this->client->getToken('password', $user->email ?? "", $request->input('password'));
        return $this->jsonReponse($response['body'], $response['status']);
    }

    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();
        $this->repository->revokeRefreshToken($accessToken->id);
        $accessToken->revoke();
        return $this->noContent();
    }
}
