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
        FBHelper::saveAllGroupPostsToRooms();

        $unpublished_posts = DB::select(
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
                'published_at' => null
                // TODO: limit to oldest 10
            ]
        );

        return Respond::prettyJson(
            message: 'fb_posts',
            data: [
                'unpublished_posts' => $unpublished_posts
            ]
        );

        //     return Respond::twig(
        //         view: 'admin.twig',
        //         parameters: [
        //             'unpublished_posts' => $unpublished_posts
        //         ]
        //     );
    }


    // publish post method
}
