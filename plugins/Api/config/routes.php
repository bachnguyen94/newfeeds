<?php
use Cake\Routing\Router;

Router::plugin('Api', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

require __DIR__ . '/constant.php';