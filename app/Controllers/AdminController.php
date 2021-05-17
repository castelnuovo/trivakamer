<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Controllers\Controller;
use App\Helpers\FBHelper;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

final class AdminController extends Controller
{
    /**
     * Delete user webhook app specific
     */
    public function index(): JsonResponse
    {
        $fb_groups = DB::select(
            table: 'fb_groups',
            columns: [
                'id',
                'fb_group_id',
                'last_checked_at'
            ],
            where: [
                'enabled' => true
            ]
        );

        $fb = FBHelper::get();
        $posts = [];

        foreach ($fb_groups as $fb_group) {
            try {
                $response = $fb->get("/{$fb_group['fb_group_id']}/feed");
                $posts[] = $response->getGraphEdge()->asArray();

                // TODO: use last_checked_at

                DB::update(
                    table: 'fb_groups',
                    data: [
                        'last_checked_at' => date('Y-m-d H:i:s')
                    ],
                    where: [
                        'id' => $fb_group['id']
                    ]
                );
            } catch (\Throwable) {
                // This group is ignored
            }
        }

        return Respond::prettyJson(
            message: 'yeet',
            data: $posts
        );
    }
}
