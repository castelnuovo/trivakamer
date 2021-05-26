<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Controllers\Controller;
use App\Helpers\FBHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class AdminController extends Controller
{
    /**
     * Show unpublished posts to admin
     */
    public function index(): HtmlResponse | JsonResponse
    {
        FBHelper::saveAllGroupPostsToDB();

        $unpublished_rooms = DB::select(
            table: 'rooms',
            columns: [
                'id',
                'description',
                'price_monthly',
                'size_m2',
                'address',
                'published_at',
                'updated_at',
                'created_at'
            ],
            where: [
                'published_at' => null,
                'LIMIT' => 5
            ]
        );

        $published_rooms = DB::select(
            table: 'rooms',
            columns: [
                'id',
                'description',
                'price_monthly',
                'size_m2',
                'address',
                'published_at',
                'updated_at',
                'created_at'
            ],
            where: [
                'published_at[!]' => null,
                // 'LIMIT' => 5
            ]
        );

        return Respond::twig(
            view: 'admin.twig',
            parameters: [
                'unpublished_rooms' => $unpublished_rooms,
                'published_rooms' => $published_rooms
            ]
        );
    }
}
