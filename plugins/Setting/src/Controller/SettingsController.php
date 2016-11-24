<?php
namespace Setting\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Database\Query;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Phinx\Migration\AbstractMigration;
use Cake\ORM\TableRegistry;
use Setting\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \Setting\Model\Table\SettingsTable $Settings
 * @property string layout
 * @property bool|object Core
 */
class SettingsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->updateDB();
    }

    /**
     * Edit method
     *
     * @internal param null|string $id Setting id.
     */
    public function index()
    {
        $this->layout = 'Admin.default';

        $stConfig = Configure::read('Core.Settings');

        $setting = $this->Settings->find()->first() ? $this->Settings->find()->first() : $this->Settings->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->data);
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved'), ['plugin' => 'Admin']);
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The setting could not be saved'), ['plugin' => 'Admin']);
            }
        }

        $this->set(compact('setting', 'stConfig'));
        $this->set('_serialize', ['setting']);
    }

    public function updateDB()
    {
        $folderCache = new Folder(CACHE.'/models');
        $folderCache->delete();

        $stConfig = Configure::read('Core.Settings');

        $dataSetting = $this->Settings->find()->first();

        $queryAdd = "ALTER TABLE settings ";
        $count = 0;
        foreach ($stConfig as $field => $value) {
            $count ++;
            $last = (count($stConfig) > $count) ? ', ' : '';
            $queryAdd .= "ADD ".$field." VARCHAR(255) NULL DEFAULT NULL".$last;
        }

        $conn = ConnectionManager::get('default');
        $queryDrop = "DROP TABLE settings";
        $queryCreate = "CREATE TABLE settings (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY)";
        $conn->query($queryDrop);
        $conn->query($queryCreate);
        $conn->query($queryAdd);

        if($dataSetting) {
            $dataSetting->isNew(true);
            $this->Settings->save($dataSetting);
        }
    }

}
