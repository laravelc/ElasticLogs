<?php

return [
    'host' => env('ELASTIC_HOST', 'http://localhost:9200'),
    'index' => env('ELASTIC_LOGS_INDEX'),
    'type' => '_doc',
];
