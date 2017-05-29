<?php 

$app->post('/api/register', 'App\Controllers\UserController:register');
$app->post('/api/login', 'App\Controllers\UserController:login');