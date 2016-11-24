<?php
use Cake\Routing\Router;

Router::plugin('Page', function ($routes) 
{
    Router::connect('/admin/pages',['plugin'=>'Page','controller' => 'Pages','action'=>'index']);
    Router::connect('/admin/pages/edit/:id',['plugin'=>'Page','controller' => 'Pages','action'=>'edit'],['pass' => ['id']]);
    Router::connect('/admin/pages/view/:id',['plugin'=>'Page','controller' => 'Pages','action'=>'view'],['pass' => ['id']]);
    Router::connect('/page/:code',['plugin'=>'Page','controller' => 'Pages','action'=>'detail'],['pass' => ['code']]);
                
    $routes->fallbacks('InflectedRoute');
});