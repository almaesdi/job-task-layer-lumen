<?php

$environment = "desa";

return [
    'prod' => [
        'tps_esb_url' => '',
    ],

    'qa' => [
        'tps_esb_url' => '',
    ],

    'desa' => [
        'tps_esb_url' => 'http://esbdesa.tpsv.cl:8181/cxf/',
        'login_service_name' => 'N4LoginService?wsdl',
    ],

    'local' => [
        'tps_esb_url' => 'http://localhost:8181/cxf/',
        'login_service_name' => 'N4LoginService?wsdl',
    ],
][$environment];
