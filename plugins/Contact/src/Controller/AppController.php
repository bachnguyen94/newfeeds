<?php

namespace Contact\Controller;
use App\Controller\AppController as BaseController;
use Cake\Database\Schema\Table;
use Cake\Datasource\ConnectionManager;

class AppController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        
        //$this->createDB();
    }
    
    function createDB()
    {
        $db = ConnectionManager::get('default');                        
        $contacts = new Table('contacts');
        
        $contacts->addColumn('id', ['type'=>'integer'])
            ->addColumn('name', ['type'=>'string','null'=>false])
            ->addColumn('email', ['type'=>'string','null'=>false])
            ->addColumn('phone', ['type'=>'string'])
            ->addColumn('address', ['type'=>'string'])
            ->addColumn('content', ['type'=>'string','length'=>4000, 'null'=>false])
            ->addColumn('read', ['type'=>'boolean','default' => 0, 'null'=>false])
            ->addColumn('ip', ['type'=>'string','length'=>16])
            ->addColumn('created', ['type'=>'datetime','null'=>false])
            ->addConstraint('primary', ['type' => 'primary','columns' => ['id']]);
        
        // Create a table
        $queries = $contacts->createSql($db);
        foreach ($queries as $sql) 
        {
            $db->execute($sql);
        }
    }
}
