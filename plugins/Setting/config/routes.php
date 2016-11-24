<?php
use Cake\Routing\Router;

Router::plugin('Setting', function ($routes) {
    Router::connect('/admin/settings',['plugin'=>'Setting','controller' => 'Settings','action'=>'index']);

    $routes->fallbacks('InflectedRoute');
});
