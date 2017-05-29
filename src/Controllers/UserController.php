<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    public function register(Request $request, Response $response)
    {
    	$user = new \App\Models\Users\User;

    	$addUser = $user->register($request->getParsedBody());

    	$find = $user->find('id', $addUser)->fetch();

    	return $this->responseDetail("Register Success", 201, $find);
    }

    public function login(Request $request, Response $response)
    {
    	$user = new \App\Models\Users\User;

        $login = $user->find('username', $request->getParsedBody()['username'])->fetch();	

        if (empty($login)) {
            $data = $this->responseDetail("Error", 401, "Username Not Registered");
        } elseif(!empty($login)) {
            $check = password_verify($request->getParsedBody()['password'], $login['password']);

            if ($check) {
            	$this->logger->pushHandler(new \App\Extensions\Logs\UserLog);

            	$this->logger->info('User has been login', ['user_id' => $login['id']]);

            	return $this->responseDetail("Login Success", 200, $login);
            } else {
            	return $this->responseDetail("Error", 401, "Wrong Password");
            }
        }
    }
}