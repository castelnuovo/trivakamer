<?php

namespace App\Helpers;

use CQ\DB\DB;
use CQ\Helpers\AppHelper;
use CQ\Helpers\ConfigHelper;
use Facebook\Facebook;

final class FBHelper
{
    public static function get(): Facebook
    {
        return new Facebook([
            'app_id' => ConfigHelper::get('facebook.id'),
            'app_secret' => ConfigHelper::get('facebook.secret'),
            'default_access_token' => ConfigHelper::get('facebook.access_token'),
            'default_graph_version' => 'v2.10',
        ]);
    }

    /**
     * Query all groups and save new rooms to db
     */
    public static function saveAllGroupPostsToRooms(): void
    {
        $fb_groups = DB::select(
            table: 'fb_groups',
            columns: [
                'id',
                'last_checked_at'
            ],
            where: [
                'enabled' => true
            ]
        );

        foreach ($fb_groups as $fb_group) {
            FBHelper::saveGroupPostsToRoom($fb_group);
        }
    }

    /**
     * Query group and save new rooms to db
     */
    public static function saveGroupPostsToRoom(array $fb_group): void
    {
        $fb = self::get();
        $post_fields = "id,created_time,message"; // TODO: image support

        try {
            $unix_last_checked_at = strtotime(datetime: $fb_group['last_checked_at']);
            $fb_response = $fb->get("/{$fb_group['id']}/feed?fields=id&since={$unix_last_checked_at}");
            $posts = $fb_response->getGraphEdge()->asArray();
        } catch (\Throwable $e) {
            if (AppHelper::isDebug()) {
                throw $e;
            }

            // No access to group

            return;
        }

        DB::update(
            table: 'fb_groups',
            data: [
                'last_checked_at' => date('Y-m-d H:i:s')
            ],
            where: [
                'id' => $fb_group['id']
            ]
        );

        foreach ($posts as $post) {
            $fb_response = $fb->get("/{$post['id']}?fields={$post_fields}");
            $post = $fb_response->getGraphNode()->asArray();

            $post['created_time'] = $post['created_time']->format('Y-m-d H:i:s');

            // Skip weird group_created post
            if (!array_key_exists(key: 'message', array: $post)) {
                continue;
            }

            try {
                DB::create(
                    table: 'rooms',
                    data: [
                        'id' => $post['id'],
                        'description' => $post['message'],
                        'created_at' => $post['created_time']
                    ]
                );
            } catch (\Throwable $e) {
                if (AppHelper::isDebug()) {
                    throw $e;
                }

                // Room already exists
            }
        }
    }
}
