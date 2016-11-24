<?php
use Cake\Routing\Router;

Router::plugin('Cms', function ($routes) 
{
    Router::connect('/admin/cms',['plugin'=>'Cms','controller' => 'Cms','action'=>'index']);
    Router::connect('/p/*',['plugin'=>'Cms','controller' => 'Cms','action'=>'view']);
    
    Router::connect('/admin/cms/index',['plugin'=>'Cms','controller' => 'Cms','action'=>'index']);
    Router::connect('/admin/cms/index/:id',['plugin'=>'Cms','controller' => 'Cms','action'=>'index'],['pass' => ['id']]);
    
    Router::connect('/admin/cms/add',['plugin'=>'Cms','controller' => 'Cms','action'=>'add']);
    Router::connect('/admin/cms/add/:id',['plugin'=>'Cms','controller' => 'Cms','action'=>'add'],['pass' => ['id']]);
    
    Router::connect('/admin/cms/edit',['plugin'=>'Cms','controller' => 'Cms','action'=>'edit']);
    Router::connect('/admin/cms/edit/:id',['plugin'=>'Cms','controller' => 'Cms','action'=>'edit'],['pass' => ['id']]);
    
    $routes->fallbacks('InflectedRoute');
});
