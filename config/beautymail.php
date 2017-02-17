<?php

return [

    // These CSS rules will be applied after the regular template CSS

    /*
        'css' => [
            '.button-content .button { background: red }',
        ],
    */

    'colors' => [

        'highlight' => env('MAIL_HIGHLIGHT_COLOR', '#004ca3'),
        'button' => env('MAIL_BUTTON_COLOR', '#004cad'),

    ],

    'view' => [
        'senderName' => env('MAIL_SENDER_NAME', null),
        'reminder' => null,
        'unsubscribe' => null,
        'address' => env('MAIL_LOCATION_ADDRESS', null),

        'logo' => [
            'path' => env('MAIL_LOGO', '%PUBLIC%/vendor/beautymail/assets/images/sunny/logo.png'),
            'width' => env('MAIL_LOGO_WIDTH', ''),
            'height' => env('MAIL_LOGO_HEIGHT', ''),
        ],

        'twitter' => null,
        'facebook' => null,
        'flickr' => null,
    ],

];
