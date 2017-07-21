<?php

namespace App\Http\Controllers;

use App\Client\LoginClient;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Login for mobile user
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = $this->repository->getWhere('username', $request->input('username'), true);
        $response = $this->client->getToken('password', $user->email ?? "", $request->input('password'));
        return $this->jsonReponse($response['body'], $response['status']);
    }

    /**
     * Logout for mobile user
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();
        $this->repository->revokeRefreshToken($accessToken->id);
        $accessToken->revoke();
        return $this->noContent();
    }

    /**
     * Login for admin
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAdmin(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');
        $token = Auth::guard("api-admin")->attempt($credentials);
        $status = 200;
        $response = [];
        if($token) {
            $user = Auth::guard("api-admin")->user();
            $response['access_token'] = $token;
            $response['id'] = $user['id'];
            $response['username'] = $user['username'];
            $response['token_type'] = "Bearer";
        }
        else {
            $status = 401;
            $response['error'] = "invalid_credentials";
            $response['message'] = "The user credentials were incorrect.";
        }
        return $this->jsonReponse($response, $status);
    }
}
