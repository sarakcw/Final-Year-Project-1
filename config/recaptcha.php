<?php

return [
    'Recaptcha' => [
        'enable' => true,
        'sitekey' => getenv('RECAPTCHA_SITE_KEY'),
        'secret' => getenv('RECAPTCHA_SECRET_KEY'),
        'type' => 'image',
        'theme' => 'light',
        'lang' => 'es',
        'size' => 'normal',
    ]
];
