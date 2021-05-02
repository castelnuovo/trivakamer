<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Helpers\AuthHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\Respond;

final class UserController extends Controller
{
    /**
     * Dashboard screen.
     */
    public function dashboard(): HtmlResponse
    {
        $msg = match ($this->requestHelper->getQueryParam('msg')) {
            'error' => 'Please try again',
            'logout' => 'You have been logged out',
            'not_verified' => 'Please verify your email',
            'not_registered' => 'Please create an account',
            default => ''
        };

        return Respond::twig(
            view: 'index.twig',
            parameters: [
                'message' => $msg,
                'logged_in' => AuthHelper::isValid(),
            ]
        );

        // return Respond::twig(
        //     view: 'dashboard.twig'
        // );
    }
}
