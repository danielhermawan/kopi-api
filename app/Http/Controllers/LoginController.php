<?php

namespace App\Http\Controllers;

use App\Client\LoginClient;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;

class LoginController extends Controller
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
        $response = $this->client->getToken('password', $user->email, $request->input('password'));
        return response()->json($response['body'], $response['status']);
    }
}
