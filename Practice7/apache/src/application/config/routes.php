<?php

return [

    'admin' => [
        'controller' => 'admin',
        'action' => 'users'
    ],

    'admin/api' => [
        'controller' => 'admin',
        'action' => 'api'
    ],

    'forecast/now' => [
        'controller' => 'forecast',
        'action' => 'now'
    ],

    'forecast/history' => [
        'controller' => 'forecast',
        'action' => 'history'
    ],

    'forecast/api' => [
        'controller' => 'forecast',
        'action' => 'api'
    ],

    'pdf' => [
        'controller' => 'pdf',
        'action' => 'show'
    ],

    'pdf/upload' => [
        'controller' => 'pdf',
        'action' => 'upload'
    ],

    'session' => [
        'controller' => 'session',
        'action' => 'start'
    ],

    'session/page' => [
        'controller' => 'session',
        'action' => 'page'
    ],

    'statistics' => [
        'controller' => 'statistics',
        'action' => 'show'
    ],


];
