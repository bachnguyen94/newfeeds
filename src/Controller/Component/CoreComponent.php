<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Core component
 * @property mixed Settings
 */
class CoreComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function initialize(array $config) 
    {
        parent::initialize($config);
    }
    
    /**
     * save email to stack and be sent by cron job
     * @throws Exception
     * @param int $templateID : The template ID hardcode by the system
     * @param array $option : $option[email] is required (it's the email of the receiver)
     * @return void
     */
    function saveEmailStack($templateID,$option)
    {
        $this->EmailTemplates = TableRegistry::get('EmailTemplates');
        $this->EmailStacks = TableRegistry::get('EmailStacks');
        
        $template = $this->EmailTemplates->find()
                        ->where(['id'=>$templateID])
                        ->first();
                
        /* ---------- Info { ---------- */
        $content = $template->content;
        
        if($option)
        {
            foreach($option as $key => $value)
            {
                $content = str_replace('['.$key.']',$value,$content);
            }
        }
        /* ---------- Info } ---------- */
        
        // Save stack
        $data = [
            'email'=>$option['email'],
            'subject'=>$template->subject,
            'content'=>$content,
            'created'=>date('Y-m-d H:i:s')
        ];
        
        $emaiStackEntity = $this->EmailStacks->newEntity();
        $emaiStackEntity = $this->EmailStacks->patchEntity($emaiStackEntity, $data);
        return $this->EmailStacks->save($emaiStackEntity);
    }
    
    public function getResources($pluginName=null)
    {
        if(!empty($pluginName))
        {
            $path = \Cake\Core\Plugin::path($pluginName);
        }
        else
        {
            $path = ROOT.DS;
        }
        
        $path .= 'src' . DS . 'Controller';
        if(file_exists($path))
        {
            $controllers = $this->getControllers($path);                
            $resources = [];
            foreach($controllers as $controller)
            {
                $actions = $this->getActions($controller,$pluginName);
                $resources[$controller] = $actions;
            }
            return $resources;
        }
        
        return null;
    }
    
    public function getControllers($path) 
    {
        $files = scandir($path);
        $results = [];
        $ignoreList = [
            '.', 
            '..', 
            'Component', 
            'AppController.php',
        ];
        foreach($files as $file)
        {
            if(!in_array($file, $ignoreList)) 
            {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }            
        }
        
        return $results;
    }
    
    public function getActions($controllerName,$pluginName=null) 
    {
        if(empty($pluginName))
        {
            $pluginName = 'App';
        }
                   
        $className = $pluginName .'\\Controller\\'.$controllerName.'Controller';
        $class = new \ReflectionClass($className);
        $actions = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        $results = [];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach($actions as $action)
        {
            if($action->class == $className && !in_array($action->name, $ignoreList))
            {
                array_push($results, $action->name);
            }   
        }
        
        return $results;
    }
    
    public function getController() 
    {
        $controllerClasses = \Cake\App::objects('controller');
        foreach($controllerClasses as $controller) 
        { 
            if ($controller != 'AppController') 
            {
                App::uses($controller, 'Controller');
                
                $actions = get_class_methods($controller);
                
                foreach($actions as $k => $v) 
                {
                    if ($v{0} == '_') {
                        unset($actions[$k]);
                    }
                }
                $parentActions = get_class_methods('AppController');
                $controllers[$controller] = array_diff($actions, $parentActions);
            }
        }
        return $controllers;
    }

    /**
     * Customize the cake patchEntity, support the upload, patch the hasmany ...
     * @throws Exception
     * @param string $newEntity : same as default
     * @param string $data : same as default
     * @param string $model : the current Model
     * @return void
     */
    public function patchEntity($newEntity, $data, $option=[])
    {
        $model = $newEntity->source();
        $this->$model = TableRegistry::get($model);
        $entity = $this->$model->patchEntity($newEntity, $data, $option);
        
        /* ---------- Validate and upload hw-file { ---------- */
        $errorTypes = Configure::read('Core.Errors.File');
        $fieldsDelete =[];
        if (isset($entity->hw_file_errors) && $entity->hw_file_errors) {
            $hwFileErrors = $entity->hw_file_errors;
            debug($hwFileErrors);
            foreach ($hwFileErrors as $field => $errorType) {
                if ($field == 'delete') {
                    $fieldsDelete = $errorType;
                    continue;
                }
                if (!$entity->isNew() && $errorType == FILE_ERROR_EMPTY && !isset($fieldsDelete[$field])) {
                    continue;
                }
                if (array_key_exists($errorType, $errorTypes)) {
                    $messageErrorFile = $errorTypes[$errorType];
                    $entity->errors($field, $messageErrorFile);
                }
            }
        }
        if (!$entity->errors()) 
        {
            if($entity->imageFields)
            {
                foreach ($entity->imageFields as $field => $params) 
                {
                    $fileTmp = $field.'_tmp';
                    $file = $entity->$fileTmp;
                    if(!$file){
                        continue;
                    }
                    debug($file);
                    $fieldsDelete[$field] = $entity->$field;
                    if (isset($file[0]) && $file[0] && is_array($file[0])) {
                        $listFiles = [];
                        foreach ($file as $item) {
                            $entity = $this->checkValidateFile($item, $field, $entity, $params, $errorTypes);
                            $listFiles[] = \Core::uploadFile($item, $model);
                        }
                        $entity->$field = implode(',', $listFiles);
                    } else {
                        $entity = $this->checkValidateFile($file, $field, $entity, $params, $errorTypes);
                        if($entity->errors()){
                            continue;
                        }

                        $fieldDelete[$field] = $entity->$field;
                        $entity->$field = \Core::uploadFile($file, $model);
                    }

                    unset($entity->$fileTmp);
                }
            }
            
            unset($entity->hw_file_errors);

        }
        if (!$entity->errors())
        {
            if(isset($fieldsDelete) && $fieldsDelete)
            {
                foreach ($fieldsDelete as $fieldDelete => $file) {
                    $filesExplode = explode(',', $file);
                    foreach ($filesExplode as $item) {
                        $files = @scandir(WWW_ROOT.'upload'.DS.'cache_image');
                        if ($files) {
                            foreach ($files as $fileName) {
                                if ($fileName != '.' && $fileName != '..' && $item && strpos($fileName, $item)) {
                                    @unlink(WWW_ROOT.'upload'.DS.'cache_image'.DS.$fileName);
                                }
                            }
                        }
                        $modelExplode = explode('.', $model);
                        if (isset($modelExplode[1])) {
                            @unlink(PATH_IMAGE_FILE.$modelExplode[1].DS.$item);
                        }
                        @unlink(PATH_IMAGE_FILE.$model.DS.$item);
                    }

                }
            }
        }
        /* ---------- Validate and upload hw-file } ---------- */
        
        
        /* ---------- Patch hasMany { ---------- */
        /*
         * Patch the data and add new item to the hasmany, also delete those old items if no error
         */
        $hasError = false;
        if($entity->errors()) $hasError = true;
        foreach($this->$model->associations()->keys() as $many)
        {
            if(isset($entity->$many))
            {
                /* ---------- Get old IDs { ---------- */
                $oldIDs = [];
                foreach($entity->getOriginal($many) as $item)
                {
                    if($item->id)
                    {
                        array_push($oldIDs,$item->id);
                    }
                }
                /* ---------- Get old IDs } ---------- */

                $manyModel = TableRegistry::get($many);
                //$entity->$many = $manyModel->patchEntities($entity->$many,$data[$many]); Not good
                
                /* ---------- Get new IDs { ---------- */
                $newIDs = [];
                if(isset($data[$many]))
                {
                    $newEntities = $manyModel->newEntities($data[$many]);
                    $entity->$many = $newEntities;
                    
                    foreach($entity->$many as $item)
                    {
                        if($item->errors()) $hasError = true;
                        if($item->id) array_push($newIDs,$item->id);
                    }
                }
                /* ---------- Get new IDs } ---------- */

                // Delete hasMany item if no error occur
                if($hasError == false)
                {
                    $deleteIDs = array_diff($oldIDs, $newIDs); // This is those deleted data

                    if($deleteIDs)
                    {
                        $deleteIDs = implode($deleteIDs,',');
                        $manyModel->deleteAll(["id in ($deleteIDs)"]);
                    }
                }
            }
        }
        /* ---------- Patch hasMany } ---------- */
        
        return $entity;
    }

    public function checkValidateFile($file, $field, $entity, $params, $errorTypes)
    {
        if (!$file['tmp_name']) {
            $entity->$field = null;
            if (!$entity->isNew()) {
                unset($entity->$field);
                return $entity;
            }
            if ($params['required']) {
                $entity->errors($field, $errorTypes[FILE_ERROR_EMPTY]);
            }
            return $entity;
        }
        if ($file['size'] > $params['size']) {
            $entity->$field = null;
            $entity->errors($field, $errorTypes[FILE_ERROR_MAX_SIZE]);
            return $entity;
        }
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), array_map('strtolower', $params['extensions']))) {
            $entity->$field = null;
            $entity->errors($field, $errorTypes[FILE_ERROR_EXTENSION]);
            return $entity;
        }
        return $entity;
    }
    
    public function getListErrors($entErrors)
    {
        $errors = [];
        if($entErrors)
        {
            foreach($entErrors as $field => $item)
            {
                $errors[$field] = array_values($item)[0];
            }
        }
        
        return $errors;
    }

    public function setting($field)
    {
        $this->Settings = TableRegistry::get('Settings');
        $settings = $this->Settings->find()->first();

        return $settings ? $settings->$field : null;
    }
}