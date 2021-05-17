<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class AdminController extends Controller
{
    /**
     * Delete user webhook app specific
     */
    public function index(): JsonResponse
    {
        return Respond::prettyJson(
            message: 'yeet'
        );
    }
}
