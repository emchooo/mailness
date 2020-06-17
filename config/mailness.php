<?php

return [
    /*
     * Sending rate throttling
     * Default setting is 10 mails per second.
     */
    'sending_rate_limit' => [
        'number_of_mails' => 1,
        'number_of_mails_every' => 30, // seconds
    ],
];
