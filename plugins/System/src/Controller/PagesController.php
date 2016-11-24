<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace System\Controller;

use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use System\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @property bool|object UserAuths
 * @property bool|object Core
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function initialize() 
    {
        parent::initialize();
    }
    
    public function index()
    {
        
    }

    /**
     * @param null $groupID
     * @param null|string $plugin
     */
    public function auth($groupID=null,$plugin=null)
    {
        if(empty($groupID)) $this->redirect(['action'=>'auth',GROUP_ADMIN]);
            
        $listPlugin = Plugin::loaded();
        if(!empty($plugin) && !in_array($plugin, $listPlugin))
        {
            $plugin = null;
        }

        $this->loadModel('UserAuths');
        if($this->request->is('post'))
        {
            if (isset($this->request->data['data']['CheckAll'])) { // If Check All
                $data[] = [
                    'group' => $groupID,
                    'plugin' => $plugin ? $plugin : 'App',
                    'controller' => '*',
                    'action' => '*'
                ];
            }else{
                $pubActSel = isset($this->request->data['data']['ListPrivate']) ? $this->request->data['data']['ListPrivate'] : [];
                foreach($pubActSel as $action){
                    $tempAction = explode('-', $action);
                    $data[] = [
                        'group' => $groupID,
                        'plugin' => $plugin ? $plugin : 'App',
                        'controller' => $tempAction[0],
                        'action' => $tempAction[1]
                    ];
                }
            }

            //Delete all record of the current group and plugin
            $currAuths = $this->UserAuths->find()->where(['group' => $groupID, 'plugin is' => $plugin ? $plugin : 'App'])->toArray();
            foreach ($currAuths as $currAuth) {
                $this->UserAuths->delete($currAuth);
            }

            if(isset($data)) {
                //Save list action selected to database
                $userAuths = $this->UserAuths->newEntities($data);
                $error = 0;
                foreach($userAuths as $userAuth){
                    if(!$this->UserAuths->save($userAuth)) {
                        $error++;
                    }
                }

                if(!$error) {
                    $this->Flash->success(__('The actions has been saved'));
                }else{
                    $this->Flash->warring(__('The actions could not be saved'));
                }
            }
        }

        $listActions = $this->Core->getResources($plugin);

        $privateActions = $publicActions = [];

        foreach ($this->UserAuths->find()->where(['group' => $groupID, 'plugin is' => $plugin ? $plugin : 'App'])->toArray() as $item){
            if($item['controller'] == "*" && $item['action'] == "*") {
                $privateActions = $listActions;
            }else{
                if(!isset($privateActions[$item['controller']])){
                    $privateActions[$item['controller']] = [$item['action']];
                }else{
                    $privateActions[$item['controller']][] = $item['action'];
                }
            }
        }

        if($listActions){
            foreach($listActions as $key => $value){
                if(isset($privateActions[$key])){
                    $tmp = array_diff($value, $privateActions[$key]);
                    if($tmp){
                        $publicActions = array_merge($publicActions, [$key => $tmp]);
                    }
                }else{
                    $publicActions = array_merge($publicActions, [$key => $value]);
                }
            }
        }

        $this->set(compact('listPlugin','publicActions', 'privateActions'));
    }
    
    public function phpinfo()
    {
        phpinfo(); die();
    }
}