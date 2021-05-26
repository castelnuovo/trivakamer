<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Helpers\AuthHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\RedirectResponse;
use CQ\Response\Respond;

final class UserController extends Controller
{
    /**
     * Dashboard screen.
     */
    public function dashboard(): HtmlResponse|RedirectResponse
    {
        // Temporary until we have a custom dashboard page
        return Respond::redirect(
            url: '/'
        );

        return Respond::twig(
            view: 'dashboard.twig',
            parameters: [
                'logged_in' => AuthHelper::isValid(),
            ]
        );
    }
}
