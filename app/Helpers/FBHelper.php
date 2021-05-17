<?php

namespace App\Helpers;

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
}
