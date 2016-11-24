<?php
use Cake\Routing\Router;

Router::plugin('Contact', function ($routes) {
    
    Router::connect('/admin/contacts',['plugin'=>'Contact','controller' => 'Contacts','action'=>'index']);
    Router::connect('/admin/contacts/view/:id',['plugin'=>'Contact','controller' => 'Contacts','action'=>'view'],['pass' => ['id']]);
    
    Router::connect('/contact',['plugin'=>'Contact','controller' => 'Contacts','action'=>'form']);
    $routes->fallbacks('InflectedRoute');
});
