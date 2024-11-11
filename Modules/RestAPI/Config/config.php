<?php

return [
    'name' => 'RestAPI',
    'verification_required' => true,
    'sportx_item_id' => 26204850,
    'parent_sportx_id' => 23263417,
    'script_name' => 'sportx-saas-rest-api',
    'setting' => \Modules\RestAPI\Entities\RestAPISetting::class,

    'jwt_secret' => "XZXPRlUsgjNdvQHusbfBbvKZEnOcYjVgbcdr8XATGmKBgVI5SABnXWaWK0Fcv48a",
    'debug' => config('app.api_debug', false),
];
