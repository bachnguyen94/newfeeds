<?php
namespace Cms\Controller;
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
        $cms = new Table('cms');
        
        $cms->addColumn('id', ['type'=>'integer'])
            ->addColumn('parent_id', ['type'=>'integer','default' => null])
            ->addColumn('lft', ['type'=>'integer'])
            ->addColumn('rght', ['type'=>'integer'])
            ->addColumn('level', ['type'=>'integer','default' => 1,'null'=>false])
            
            ->addColumn('slug', ['type'=>'string','null'=>false])
            /* ---------- Multiple lang here { ---------- */
            ->addColumn('name', ['type'=>'string','null'=>false])
            ->addColumn('content', ['type'=>'text', 'null'=>false])
            /* ---------- Multiple lang here } ---------- */
                
            ->addColumn('icon', ['type'=>'string','null'=>true])
            ->addColumn('banner', ['type'=>'string','null'=>true])
            ->addColumn('url', ['type'=>'string','comment'=>'Go to external url'])
            ->addColumn('url_popup', ['type'=>'boolean','default' => 0, 'null'=>false,'comment'=>'Redirect or Popup new tab'])
            ->addColumn('display_order', ['type'=>'integer'])
            ->addColumn('active', ['type'=>'boolean','default' => 0, 'null'=>false])
            ->addColumn('created', ['type'=>'datetime','null'=>false])
            ->addColumn('modified', ['type'=>'datetime','null'=>false])
            ->addConstraint('primary', ['type' => 'primary','columns' => ['id']]);
            
        // Create a table
        $queries = $cms->createSql($db);
        foreach ($queries as $sql) 
        {
            $db->execute($sql);
        }
    }
}
