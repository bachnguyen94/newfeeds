<?php
use Cake\Routing\Router;

Router::plugin('Social', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
