<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\AuthHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\Respond;

final class GeneralController extends Controller
{
    /**
     * Index screen.
     */
    public function index(): HtmlResponse
    {
        $msg = match ($this->requestHelper->getQueryParam('msg')) {
            'error' => 'Please try again',
            'logout' => 'You have been logged out',
            'not_verified' => 'Please verify your email',
            'not_registered' => 'Please create an account',
            default => ''
        };

        $rooms = DB::select(
            table: 'rooms',
            columns: [
                'id',
                'price_monthly',
                'size_m2',
                'address',
                'created_at'
            ],
            where: [
                'published_at[!]' => null
            ]
        );

        return Respond::twig(
            view: 'index.twig',
            parameters: [
                'message' => $msg,
                'logged_in' => AuthHelper::isValid(),
                'rooms' => $rooms
            ]
        );
    }

    /**
     * Contact us screen
     */
    public function contact(): HtmlResponse
    {
        return Respond::twig(
            view: 'contact.twig'
        );
    }

    /**
     * About us screen
     */
    public function about(): HtmlResponse
    {
        return Respond::twig(
            view: 'about.twig'
        );
    }
}
