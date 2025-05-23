<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 30,
    'user.passwordMinLength' => 8,

    'bsVersion' => '4.x',

    'mdm.admin.configs' => [
        'defaultUserStatus' => 0, // 0 = inactive, 10 = active
    ],

    'fabric' => [
        'queryParams1' => [
            'channelid' => 'mychannel',
            'chaincodeid' => 'basic',
            'function' => 'ReadAsset',
        ]
    ],
];
