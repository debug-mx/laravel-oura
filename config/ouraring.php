<?php

return [

    /*
     |--------------------------------------------------------------------------
     | OuraRing Settings
     |--------------------------------------------------------------------------
     |
     | Custom stuff goes here
     |
     */
    'base_uri'=>[
        'authorize'=>env('OURA_BASE_URI_AUTHORIZE','https://cloud.ouraring.com'),
        'api'=>env('OURA_BASE_URI_API','https://api.ouraring.com'),
    ],

];