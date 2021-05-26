<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\GeneralController;
use App\Controllers\UserController;
use App\Controllers\AuthWebhookController;
use App\Controllers\RoomController;
use App\Middleware\AdminMiddleware;
use CQ\Controllers\AuthCodeController;
use CQ\Controllers\AuthDeviceController;
use CQ\Middleware\AuthMiddleware;
use CQ\Middleware\JsonMiddleware;

$route->get('/', [GeneralController::class, 'index']);
$route->get('/contact', [GeneralController::class, 'contact']);
$route->get('/about', [GeneralController::class, 'about']);

$route->get('/room/{roomId}', [RoomController::class, 'view']);

$middleware->create(['prefix' => '/auth'], function () use ($route, $middleware) {
    $route->get('/request', [AuthCodeController::class, 'request']);
    $route->get('/callback', [AuthCodeController::class, 'callback']);
    $route->get('/logout', [AuthCodeController::class, 'logout']);

    $route->get('/request/device', [AuthDeviceController::class, 'request']);
    $route->post('/callback/device', [AuthDeviceController::class, 'callback']);

    $middleware->create(['middleware' => [JsonMiddleware::class]], function () use ($route) {
        $route->post('/delete', [AuthWebhookController::class, 'delete']);
    });
});

$middleware->create(['middleware' => [AuthMiddleware::class]], function () use ($route, $middleware) {
    $route->get('/dashboard', [UserController::class, 'dashboard']);
    $route->get('/room/{roomId}', [RoomController::class, 'view']);

    $middleware->create(['prefix' => '', 'middleware' => [AdminMiddleware::class]], function () use ($route, $middleware) {
        $route->get('/admin', [AdminController::class, 'index']);

        $middleware->create(['middleware' => [JsonMiddleware::class]], function () use ($route) {
            $route->put('/room/{roomId}', [RoomController::class, 'update']);
        });

        $route->delete('/room/{roomId}', [RoomController::class, 'delete']);
    });
});
