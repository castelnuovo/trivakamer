<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use CQ\Helpers\AuthHelper;
use CQ\Middleware\Middleware;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\NoContentResponse;
use CQ\Response\RedirectResponse;
use CQ\Response\Respond;

class AdminMiddleware extends Middleware
{
    /**
     * Check if user is admin
     */
    public function handleChild(Closure $next): Closure | HtmlResponse | JsonResponse | NoContentResponse | RedirectResponse
    {
        $user = AuthHelper::getUser();

        if ($user->hasRole('admin')) {
            return $next($this->request);
        }

        return Respond::redirect(
            url: '/dashboard',
            code: 403
        );
    }
}
