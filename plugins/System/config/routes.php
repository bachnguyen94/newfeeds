<?php
use Cake\Routing\Router;

Router::plugin('System', function ($routes) {
    
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'index']);
    $routes->fallbacks('InflectedRoute');
});
