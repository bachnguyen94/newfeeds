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
namespace App\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property bool|object UserAuths
 * @property bool|object Users
 * @property  CurUser
 * @property bool|object CurUser
 * @property bool|object Menus
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $helpers = ['CurUser'];
    public $imageFields = [];
    var $CurUser; // The current logged-in user
    var $ajax = [           // Ajax output for ajax request
        'status'=>null,     // 'success' or 'error' (Required) If not => check the output
        'error'=>null,      // One global error message on the top
        'errors'=>[],       // The errors show out
        'redirect'=>null    // Redirect to another action
    ];
    var $buildHasMany = [];
    var $buildAjaxSelect = [];
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Core');
        $this->loadComponent('Order');
        
        $this->_setLanguage();
        $this->checkLogin();

        $this->handleAjaxRequest();
    }
    
    function handleAjaxRequest()
    {
        if($this->request->is('ajax'))
        {
            /* ---------- Sort item { ---------- */
            if(isset($this->request->data['SortOrder']))
            {
                $model = $this->loadModel($this->modelClass);
                
                $data = array();
                $i = 1;
                foreach($this->request->data['SortOrder'] as $id)
                {
                    $row = array
                    (
                        'id'=>$id,
                        'display_order'=>$i
                    );
                    array_push($data,$row);
                    ++$i;
                }
                
                foreach ($data as $item)
                {
                    $entity = $model->newEntity();
                    $entity->accessible('id',true);
                    $entity = $this->Core->patchEntity($entity, $item,['validate' => false]);
                    $model->save($entity);
                }
            }
            /* ---------- Sort item } ---------- */
        }
    }
    
    function handleAjaxFormRequest()
    {
        /* ---------- Handle Ajax Output { ---------- */
        if($this->request->is('ajax') && isset($this->request->data['ajax_form']))
        {
            $model = (isset($this->request->data['model']))?$this->request->data['model']:$this->modelClass;
            $this->ajax['plugin'] = null;
            if(!empty($this->request->params['plugin']))
            {
                $model = str_replace($this->request->params['plugin'].'.', '', $model);
                $this->ajax['plugin'] = $this->request->params['plugin'];
            }
            
            $entity = $this->$model->newEntity();
            $entity = $this->Core->patchEntity($entity, $this->request->data);

            $errors = [];
            if($entity->errors())
            {
                foreach($entity->errors() as $field => $item)
                {
                    $errors[$field] = array_values($item)[0];
                }
            }

            if($errors)
            {
                $this->ajax['status'] = AJAX_STATUS_ERROR;
                $this->ajax['errors'] = $errors;
            }
            
            if(!empty($this->ajax['status']))
            {
                echo json_encode($this->ajax);die();
            }
            else
            {
                echo 'Hey developer: The ajax status must be "success" or "error"'; 
                echo json_encode($this->ajax);die();
            }
        }
        /* ---------- Handle Ajax Output } ---------- */
    }
    
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        
        /* ---------- Image fields { ---------- */
        $model = $this->loadModel($this->modelClass);
        $entity = $model->newEntity();
        $this->imageFields = $entity->imageFields;
        $this->set('imageFields', $this->imageFields);
        /* ---------- Image fields } ---------- */
        
        $this->handleAjaxFormRequest();
        $this->set('buildAjaxSelect',$this->buildAjaxSelect);
    }
    
    /**
     * Check user is login or not
     * @return void
     */
    function checkLogin()
    {
        $this->loadModel('Users');
        
        $user = $this->request->session()->read('Core.Users');
        if(isset($user))
        {
            $user = $this->Users->find()->where(['id'=>$user->id,'status <>'=>USER_STATUS_DELETED])->first();
            if($user->status == USER_STATUS_BLOCK)
            {
                $this->request->session()->delete('Core.Users');
                $this->redirect(['controller'=>'pages','action'=>'home']);
            }
            $this->CurUser = (object)$user->toArray();
            $_SESSION['UserID'] = $user->id;
        }
        
        /* ---------- Api Plugin { ---------- */
        if($this->request->params['plugin'] == 'Api') $this->apiGetUserByToken();
        /* ---------- Api Plugin } ---------- */

        $this->checkAuth();
    }
    
    /**
     * Check user allow access action
     * @return void
     */
    function checkAuth()
    {
        $this->loadModel('UserAuths');
        $curP = ($this->request->params['plugin'])?$this->request->params['plugin']:'App';
        $curC = $this->request->params['controller'];
        $curA = $this->request->params['action'];
        $auth = $this->UserAuths->find()->toArray();
        $isLogin = (isset($this->CurUser->id))?true:false;
        $allowAccess = true; // Default allow access all actions
        
        //debug($this->request->params);
        
        // Check if current url is own by someone
        foreach($auth as $item)
        {
            if($item->plugin == $curP && $item->controller == '*' && $item->action == '*')
            {
                // true => 
                $allowAccess = false;
            }
            else if($item->plugin == $curP && $item->controller == $curC && $item->action == $curA)
            {
                // true => 
                $allowAccess = false;
            }
        }
        
        // Check if logged in user can access that action
        if($isLogin)
        {
            foreach($auth as $item)
            {
                if($item->group == $this->CurUser->group && $item->plugin == $curP && $item->controller == '*' && $item->action == '*')
                {
                    // true => 
                    $allowAccess = true;
                }
                else if($item->group == $this->CurUser->group && $item->plugin == $curP && $item->controller == $curC && $item->action == $curA)
                {
                    // true => 
                    $allowAccess = true;
                }
            }
        }
        
        if($allowAccess == false)
        {
            /* ---------- Api Plugin { ---------- */
            if($this->request->params['plugin'] == 'Api')
            {
                $this->Output['status'] = API_STATUS_ERROR;
                $this->Output['error_code'] = ERROR_INVALID_AUTH;
                $this->writeOutput();
            }
            /* ---------- Api Plugin } ---------- */
            
            //echo '<div style = "padding:5px;background-color:red;color:white;">Invalid auth for this group. <a href="'.$this->request->webroot.'system/pages/auth">Click here</a> to manage auth.</div>';
            $this->Flash->error(__('Invalid user authentication'));
            $url = Router::url('/', true);
            header("Location: $url"); 
            exit; // Need this to force redirect
        }
    }
    
    /**
     * Used to link related combobox (child combobox items is bind after ajax call of parent combobox)
     * Note: if you need to have another of comboboxes group on the same form, call this function again with other $option
     * @throws Exception
     * @param string $option : Ex:
     *  ['model'=>'Menus','keyField'=>'id','valueField'=>'name','select'=>'#cbTop','where'=>['parent_id is'=>null]],
        ['model'=>'Menus','keyField'=>'id','valueField'=>'name','select'=>'#cbModule','parentField'=>'parent_id'],
        ['model'=>'Menus','keyField'=>'id','valueField'=>'name','select'=>'#cbProduct','parentField'=>'parent_id']
     * 
     * model : The model related to that combobox
     * keyField / valueField : Use in find('list')
     * currentValue : the default selected item of combobox
     * select : The jquery select of that combobox
     * where : additional condition
     * @return void
     */
    function buildAjaxSelect($option)
    {
        $parentValue = null;
        foreach($option as $index => $item)
        {
            $model = $item['model'];
            $keyField = (isset($item['keyField']))?$item['keyField']:'id';
            $valueField = (isset($item['valueField']))?$item['valueField']:'name';
            
            $this->loadModel($model);
            
            $list = $this->$model->find('list',['keyField'=>$keyField,'valueField'=>$valueField]);
            if(isset($item['parentField']))
            {
                $list->where([$item['parentField']=>$parentValue]);
            }
            
            if(isset($item['where']))
            {
                $list->where($item['where']);
            }
            
            $option[$index]['data'] = $list->toArray();
            $parentValue = (isset($item['currentValue']))?$item['currentValue']:null;
        }
        
        $this->buildAjaxSelect[] = $option;
    }
    
    /**
     * Support add/edit hasMany on the same form
     * @throws Exception
     * @param string $mainEntity : The main entity
     * @param string $hasManyName : The name of the hasMany that related to the main entity
     * @param string $option['container'] : The jquery selection for the container
     * @param string $option['add'] : The jquery selection for the add button
     * @param string $option['delete'] : The jquery selection for the delete button
     * @return void
     */
    public function buildHasMany($mainEntity,$hasManyName,$option)
    {
        /* Ex: 
         * $mainEntity = $user
         * $hasManyName = 'menus'
         * $option['container'] = '#myContainer'
         * $option['add'] = '.btn_add'
         * $option['delete'] = '.btn_delete'
         */
                
        $arrData = 
        [
            'name'=> $hasManyName,
            'entities'=>[],
            'option'=>$option,
            'plugin'=>($this->request->params['plugin'])?$this->request->params['plugin']:null
        ];

        if ($mainEntity->$hasManyName) {
            foreach($mainEntity->$hasManyName as $ent)
            {
                $data = array
                (
                    'ent'=>$ent->toArray(),
                    'errors'=>$this->Core->getListErrors($ent->errors())
                );

                array_push($arrData['entities'],$data);
            }
        }

        $this->buildHasMany[] = $arrData;
        $this->set('buildHasMany',$this->buildHasMany);
    }
    
    /**
     * Allow client to click 'View More' and load the ajax content.
     * @throws Exception
     * @param string $model : Model to paging
     * @param string $element : The cakephp element path & name
     * @param string $dataName : The set data use in element (Ex: $this->set('products',$data) , the $dataName here is 'products'
     * @param string $option['container'] : the Jquery selection for the container
     * @param string $option['link'] : the Jquery selection for link 'View More'
     * @return void
     */
    public function buildAjaxMore($model=null,$element=null,$dataName=null,$option)
    {                
        // Handle ajax paging
        if(isset($_GET['ajax_more']))
        {
            $model = $_GET['model'];
            $element = $_GET['element'];
            $this->loadModel($model);
            
            $data = $this->paginate($this->$model)->toArray();
            $this->set($dataName,$data);
            $this->layout = 'ajax';
            $this->render('/Element/'.$element);
        }
        else
        {
            $this->loadModel($model);
            $data = $this->paginate($this->$model)->toArray();
            
            $this->set($dataName,$data);
            $this->set('buildAjaxMore',[
                'model'=>$model,
                'element'=>$element,
                'page'=>$this->request->params['paging'][$model]['page'],
                'pageCount'=>$this->request->params['paging'][$model]['pageCount'],
                'container'=>$option['container'],
                'link'=>$option['link']
            ]);
        }
    }

    public function _setLanguage()
    {
        $lang = $this->request->session()->read('Config.language');
        if(!$lang) {
            // Automatic detect locale for user
            $lang = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))?locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']):'en';
            switch ($lang) {
                case 'ja':
                    $lang = 'ja_JP';
                    break;
                case 'vi':
                    $lang = 'vi_VN';
                    break;
                case 'en':
                    $lang = 'en_US';
                    break;
            }
            $this->request->session()->write('Config.language', $lang);
        }
        $this->set('lang', $lang);

        I18n::locale($lang);
        \Cake\Core\Configure::load('constant', 'default', false);
    }
    
    /**
     * Set field boolean
     *
     * @param string $field
     */
    public function set_active($field = 'active')
    {
        $this->viewBuilder()->layout(false);
        $this->autoRender = false;

        if($this->request->is('ajax')) {
            $model = $this->modelClass;
            if(!empty($this->request->params['plugin'])) {
                $model = str_replace($this->request->params['plugin'].'.', '', $model);
            }

            $entity = $this->$model->get($this->request->data['id']);
            $entity->$field =  $this->request->data[$field];

            if ($this->$model->save($entity)) {
                echo json_encode(['status' => true]);
            }
        }
    }
    
    /**
     * description
     * @throws Exception
     * @param string $name : des
     * @return void
     */
    public function ajax_get_select_child_items($model,$parentField,$parentValue,$keyField,$valueField)
    {
        $this->loadModel($model);
        $childItems = $this->$model->find('list',['keyField'=>$keyField,'valueField'=>$valueField])->where([$parentField=>$parentValue]);
        echo json_encode($childItems);die;
    }
}