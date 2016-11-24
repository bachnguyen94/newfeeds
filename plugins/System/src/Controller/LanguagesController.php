<?php
namespace System\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\I18n\I18n;
use Cake\Shell\I18nShell;
use DateTime;
use Page\Test\TestCase\View\Helper\PageHelperTest;
use Psy\Exception\ErrorException;
use System\Controller\AppController;

/**
 * Languages Controller
 *
 * @property \System\Model\Table\LanguagesTable $Languages
 */
class LanguagesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('languages', $this->Languages->find());
        $this->set('_serialize', ['languages']);
    }

    public function server_index()
    {
        $this->setDataSource();
        $dbServer = ConnectionManager::get('server_hw');
        $colTblServer = $this->getColumn($dbServer);
        $languages = $dbServer->execute('select * from languages')->fetchAll('assoc');
        $this->set(compact('languages', 'colTblServer'));
    }

    /**
     * Update new key method
     */
    public function update_new_key()
    {
        /* ---------- Get all language keys in the system { ---------- */
        $arrDir = [
            '../src/',
            '../plugins/',
            '../config/',
        ];
        
        $fileList = [];
        foreach($arrDir as $item)
        {
            $dir = new Folder($item);
            $fileList = array_merge($fileList,$this->_directoryToArray($dir->path));
        }
        
        $allKey = array();
        foreach($fileList as $file) {
            $ext = $this->_getFileExtension($file);
            if(!in_array($ext,array('php','ctp'))) continue;

            $content = file_get_contents($file);
            $pattern = "^\__\('(.*?)\'\)^";
            preg_match_all($pattern, $content, $matches);
            if(isset($matches[1])) {
                foreach($matches[1] as $match) {
                    array_push($allKey,$match);
                }
            }
        }
        $allKey = array_unique($allKey);
        /* ---------- Get all language keys in the system } ---------- */

        /* ---------- Add new key to the system { ---------- */
        $list = $this->Languages->find()->where(['key in' => $allKey])->toArray();

        $existKey = array();
        foreach($list as $item) {
            array_push($existKey,$item->key);
        }

        $arrNewKey = array();
        foreach($allKey as $key) {
            if(!in_array($key,$existKey) && strpos($key, '<?=') === false && strpos($key, '<%=') === false && strpos($key, '$') === false) {
                $newKey = array (
                    'key'=>$key
                );
                array_push($arrNewKey,$newKey);
            }
        }

        if(!empty($arrNewKey)) {
            $languages = $this->Languages->newEntities($arrNewKey);
            $err = true;
            foreach ($languages as $language){
                if ($this->Languages->save($language)) {
                    $err = false;
                }
            }
            if(!$err) {
                $this->Flash->success(__('New keys updated', true));
            } else {
                $this->Flash->error(__('Error update new key', true));
            }
        } else {
            $this->Flash->error(__('No new key found', true));
        }

        $this->redirect(array('action' => 'index'));
        /* ---------- Add new key to the system } ---------- */
    }

    /**
     * Find directory and generate to array
     *
     * @param $directory
     * @param bool $recursive
     * @return array
     */
    public function _directoryToArray($directory, $recursive=true)
    {
        $array_items = array();
        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_dir($directory. "/" . $file)) {
                        if($recursive) {
                            $array_items = array_merge($array_items, $this->_directoryToArray($directory. "/" . $file, $recursive));
                        }
                        $file = $directory . "/" . $file;
                        $array_items[] = preg_replace("/\/\//si", "/", $file);
                    } else {
                        $file = $directory . "/" . $file;
                        $array_items[] = preg_replace("/\/\//si", "/", $file);
                    }
                }
            }
            closedir($handle);
        }
        return $array_items;
    }

    /**
     * get file extension of the file
     *
     * @param $str
     * @return string
     */
    function _getFileExtension($str)
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }


    /**
     * Add or edit method
     *
     * @param null $id
     * @return \Cake\Network\Response|void
     */
    public function add($id = null)
    {
        $language = $id ? $this->Languages->get($id) : $this->Languages->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $language = $this->Languages->patchEntity($language, $this->request->data);
            if ($this->Languages->save($language)) {
                $this->Flash->success(__('The language has been saved'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The language could not be saved'));
            }
        }
        $this->set(compact('language'));
        $this->set('_serialize', ['language']);
    }

    public function server_add()
    {
        $this->setDataSource();
        $dbServer = ConnectionManager::get('server_hw');
        $colTblServer = $this->getColumn($dbServer);

        if ($this->request->is('post')) {
            if($dbServer->insert('languages', $this->request->data)) {
                $this->Flash->success(__('The key has been saved'));
                $this->redirect(['action' => 'server_index']);
            } else {
                $this->Flash->error(__('The key could not be saved'));
            }
        }

        $this->set(compact('colTblServer'));
    }

    public function server_edit($id = null)
    {
        $this->setDataSource();
        $dbServer = ConnectionManager::get('server_hw');
        $colTblServer = $this->getColumn($dbServer);

        if (!$id) {
            throw new NotFoundException(__('User is invalid'));
        }

        if ($this->request->is('post')) {
            if($dbServer->update('languages', $this->request->data, ['id' => $this->request->data['id']])) {
                $this->Flash->success(__('The key has been saved'));
                $this->redirect(['action' => 'server_index']);
            } else {
                $this->Flash->error(__('The key could not be saved'));
            }
        }

        $this->request->data = $dbServer->execute('select * from languages where id = '.$id)->fetchAll('assoc');

        $this->set(compact('colTblServer'));
    }

    public function server_delete($id = null)
    {
        $this->setDataSource();
        $dbServer = ConnectionManager::get('server_hw');

        if (!$id) {
            throw new NotFoundException(__('User is invalid'));
        }

        if($this->request->is(['post', 'put', 'patch'])) {
            if ($dbServer->delete('languages', ['id' => $id])) {
                $this->Flash->success(__('The key has been deleted'));
                $this->redirect(['action' => 'server_index']);
            } else {
                $this->Flash->success(__('The key could not be deleted'));
            }
        }
    }


    /**
     * Delete method
     *
     * @param string|null $id Language id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $language = $this->Languages->get($id);
        if ($this->Languages->delete($language)) {
            $this->Flash->success(__('The language has been deleted'));
        } else {
            $this->Flash->error(__('The language could not be deleted'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function export()
    {
        if($this->request->is('post')) {
            $listLang = [];
            foreach (Configure::read('Core.System.language') as $key => $item) {
                $listLang = array_merge($listLang, [$key => $item['key']]);
            }
            $lang = $this->request->data['language'];
            $list = $this->Languages->find();
            $content = "";
            $path = APP."Locale/$listLang[$lang]/default.po";
            foreach($list as $item) {
                $content .= 'msgid "'.$item->key.'"'."\n".'msgstr "'.$item->$lang.'"'."\n";
            }

            if ($File = new File($path, true, 0777)) {
                $File->write($content);
                Cache::clearGroup('persistent');
                $this->Flash->success(__('Language exported', true));
            } else {
                $this->Flash->error(__('Language can not be exported', true));
            }

            $this->redirect(array('action' => 'index'));
        }
    }

    public function pull_from_server()
    {
        $keyLocalList = $this->Languages->find('list', [
            'keyField' => 'id',
            'valueField' => 'key'
        ])->toArray();

        $this->setDataSource();
        $dbServer = ConnectionManager::get('server_hw');
        $keyServer = $dbServer->execute('select * from languages')->fetchAll('assoc');

        $keyServerList = [];
        foreach ($keyServer as $item) {
            array_push($keyServerList, $item['key']);
        }

        $keyCommon = array_intersect($keyLocalList, $keyServerList);

        $keyNeedUpdate = $this->Languages->find()->where(['id IN' => array_keys($keyCommon)])->toArray();

        if ($keyNeedUpdate) {
            $error = 0;
            foreach ($keyNeedUpdate as $item) {
                /*----------------Get conditions for fields-------{--------*/
                $fields = array_keys($item->toArray());
                $fieldNeedUpdate = [];
                $err = 0;
                foreach ($fields as $field) {
                    if ($field == 'id' || $field == 'key') continue;
                    if ($item->$field != "") {
                        $err ++;
                    } else {
                        $fieldNeedUpdate[] = $field;
                    }
                }
                /*----------------Get conditions for fields-------}--------*/
                if ($err == count($fields)) continue; // Don't update key is full value

                if($item) { // Update key local from key server
                    foreach ($keyServer as $keyUpdate) {
                        if ($item->key == $keyUpdate['key']) {
                            foreach ($fieldNeedUpdate as $field) {
                                $item->$field = $keyUpdate[$field];
                            }
                            if(!$this->Languages->save($item)) $error ++;
                        }
                    }
                }
            }
        }
        if (!$error) {
            $this->Flash->success(__('The key has been merged'));
        } else {
            $this->Flash->error(__('The key could not be merged'));
        }
        $this->redirect(['action' => 'index']);
    }

    public function push_to_server()
    {
        $keyLocal = $this->Languages->find()->where(['OR' => ['eng !=' => '', 'vie !=' => '', 'jpn !=' => '']])->toArray();

        $this->setDataSource();
        $dbServer = ConnectionManager::get('server_hw');

        $colTblServer = $this->getColumn($dbServer);
        $colTblLocal = array_keys($keyLocal[0]->toArray());

        /*-------------- Add new column to database on server------{-------*/
        $count = 0;
        $addColumnToServer = "ALTER TABLE `languages` ";
        foreach ($colTblLocal as $col) {
            $count ++;
            if (in_array($col, $colTblServer)) continue;

            $last = (count($colTblLocal) > $count) ? ', ' : '';
            $addColumnToServer .= "ADD `".$col."` VARCHAR( 255 ) NULL".$last;
        }

        try {
            $dbServer->execute($addColumnToServer);
        } catch (\Exception $ex) {die('Error');}
        /*-------------- Add new column to database on server------}-------*/

        /*-------------- Generate new key ---------{-----*/
        $keyServer = $dbServer->execute('select * from languages')->fetchAll('assoc');

        $existKey = [];
        foreach ($keyServer as $item) {
            array_push($existKey, $item['key']);
        }

        $newKey = [];
        $keyNeedUpdate = [];
        foreach ($keyLocal as $item) {
            if (in_array($item->key, $existKey)) {
                foreach ($keyServer as $key) {
                    if ($key['key'] == $item->key) {
                        /*----------------Get conditions for fields-------{--------*/
                        $fields = array_keys($key);

                        $fieldNeedUpdate = [];
                        $err = 0;
                        foreach ($fields as $field) {
//                            if ($field == 'id' || $field == 'key') continue;
                            if ($key[$field] != "") {
                                $err ++;
                            } else {
                                $fieldNeedUpdate[] = $field;
                            }
                        }
                        /*----------------Get conditions for fields-------}--------*/
                        if ($err == count($fields)) continue; // Don't update key is full value

                        if($key) { // Update key local from key server
                            foreach ($keyLocal as $keyUpdate) {
                                if ($key['key'] == $keyUpdate->key) {
                                    foreach ($fieldNeedUpdate as $field) {
                                        $key[$field] = $keyUpdate->$field;
                                    }
                                    $keyNeedUpdate[] = $key;
                                }
                            }
                        }
                    }
                }
                continue;
            }
            $newKey = array_merge($newKey, [$item->toArray()]);
        }
        /*-------------- Generate new key ---------}-----*/

        if ($this->request->is('post')) {
            /*-------------- Save to database on server -----{--------*/
            $error = 0;
            $keyError = [];
            if ($newKey) {
                foreach ($newKey as $lang) {
                    array_shift($lang);
                    if (!$dbServer->insert('languages', $lang)) {
                        $error ++;
                        array_push($keyError, $lang['key']);
                    }
                }
            }

            if ($keyNeedUpdate) {
                foreach ($keyNeedUpdate as $lang) {
                    if (!$dbServer->update('languages', $lang, ['id' => $lang['id']])) {
                        $error ++;
                        array_push($keyError, $lang['key']);
                    }
                }
            }
            /*-------------- Save to database on server -----}--------*/
            if (!$error) {
                $this->redirect(['action' => 'push_to_server']);
                $this->Flash->success(__('Update successfully'));
            } else {
                $this->Flash->warning(__('Update error {0}', json_encode($keyError)));
            }
        }

        $this->set('languages', array_merge($newKey, $keyNeedUpdate));

    }

    public function getColumn($db)
    {
        $collection = $db->schemaCollection();
        return $collection->describe('languages')->columns();
    }

    public function setDataSource()
    {
        $config = [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => '192.168.1.101',
            'username' => 'c0hiworld',
            'password' => '@hiworld',
            'database' => 'c0webcore',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => true
        ];

        ConnectionManager::config('server_hw', $config);
    }
}
