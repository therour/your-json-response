<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Json Response Skeleton
    |--------------------------------------------------------------------------
    |
    | Define the skeleton of the named response with 
    | ['SKELETON_NAME' => 'ARRAY SHAPED SKELETON']
    | skeleton name MUST defined with 
    | 1. function-identifier rule name
    | 2. not using reserved name : 
    |   'make', 'view', 'json', 'jsonp', 'stream', 
    |   'streamDownload', 'download', 'fallbackName',
    |   'file', 'redirectTo', 'redirectToRoute', 'redirectToAction',
    |   'redirectToGuest', 'redirectToIntended'
    |
    | YJResponse use macro to Illuminate\Support\Facades\Response
    | so named skeleton could be called with 
    | response()->{ SKELETONE_NAME }()
    |
    | eg: return response()->success($data, $message, $code)
    |
    */
    'skeleton' => [

        'ok' => [

            'status' => [
                'type',
                'message',
                'code',
                'error' => 'false'
            ],
            'data',
            'meta_page'

        ],

        'fail' => [

            'status' => [
                'type',
                'message',
                'code',
                'error' => 'true'
            ],

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Json Response Default Value
    |--------------------------------------------------------------------------
    | 
    | Only support for variables: 'code', 'message'
    |
    */
    'defaults' => [
        'success' => [
            'code' => 200,
            'message' => ''
        ],

        'fail' => [
            'code' => 500,
            'message' => ''
        ]
    ]
];
