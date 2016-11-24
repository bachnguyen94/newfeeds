<?php

namespace Api\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController
{
    var $Entity;
    var $Output;
    
    public function initialize()
    {
        parent::initialize();
    }
    
    public function beforeRender(\Cake\Event\Event $event)
    {
        parent::beforeRender($event);
        
        if($this->Entity)
        {
            $errors = [];
            if($this->Entity->errors())
            {
                foreach($this->Entity->errors() as $field => $item)
                {
                    $errors[$field] = array_values($item)[0];
                }
            }

            if($errors)
            {
                $this->Output['status'] = API_STATUS_ERROR;
                $this->Output['error_code'] = ERROR_INVALID_VALIDATION;
                $this->Output['errors'] = $errors;
            }
        }
        
        $this->writeOutput();
    }
    
    public function writeOutput()
    {
        if(isset($this->Output['error_code']))
        {
            $this->Output['error_msg'] = Configure::read('E.'.$this->Output['error_code']);
        }
        
        if(empty($this->Output['status']))
        {
            echo 'Hey developer: The output status must be "success" or "error"'; die();
        }
        else
        {
            echo json_encode($this->Output);die();
        }
    }
    
    /**
     * Get the data from $_POST (json object) or $_GET
     * @throws Exception
     * @param array $requiredFields : fields required
     * @return $requestData : the data from $_POST or $_GET
     */
    public function getRequestData($requiredFields=null)
    {
        if($this->request->is('post'))
        {
            if(!isset($_POST['data']))
            {
                $this->Output['status'] = API_STATUS_ERROR;
                $this->Output['error_code'] = ERROR_INVALID_POST_DATA;
                $this->writeOutput();
            }

            $requestData = json_decode($_POST['data'],true);
            if($requestData === null)
            {
                $this->Output['status'] = API_STATUS_ERROR;
                $this->Output['error_code'] = ERROR_INVALID_JSON_OBJECT;
                $this->writeOutput();
            }
            
            if($_FILES)
            {
                foreach($_FILES as $field => $data)
                {
                    $requestData[$field] = $data;
                }
            }
        }
        else
        {
            $requestData = $this->request->query;
        }
        
        if($requiredFields)
        {
            foreach($requiredFields as $field)
            {
                if(!isset($requestData[$field]))
                {
                    $this->Output['status'] = API_STATUS_ERROR;
                    $this->Output['error_code'] = ERROR_INVALID_MISSING_PARAM;
                    $this->writeOutput();
                }
            }
        }
        
        return $requestData;
    }
    
    /**
     * Try to use api token to get user in fo
     * @throws Exception
     * @return $this->CurUser (if token is valid)
     */
    public function apiGetUserByToken()
    {
        $requestData = $this->getRequestData();
        if(isset($requestData['token']))
        {
            $user = $this->Users->find()->where(['auth_token'=>$requestData['token'],'status <>'=>USER_STATUS_DELETED])->first();
            if($user)
            {
                if($user->status == USER_STATUS_BLOCK)
                {
                    $this->Output['status'] = API_STATUS_ERROR;
                    $this->Output['error_code'] = ERROR_EXCEPTION_USER_BLOCK;
                    $this->writeOutput();
                }
                $this->CurUser = (object)$user->toArray();
            }
        }
    }
    
    /**
     * change $_GET params to cakephp select convention
     * @throws Exception
     * @param $_GET['paging'] : paging or normal select
     * @param $_GET['page'] : if paging = 1 => page is the current page
     * @param $_GET['select'] : field to show out
     * @param {fieldname}={op}{value} : conditions of the query
     * {fieldname} : any field name in that model
     * {op} : can be > , < , >= , <=, <>
     * {value} : the value
     * *{value}* : search like
     * @param $_GET['sort'] : field name to sort
     * @param $_GET['direction'] : direction of sort
     * @return $query
     */
    
    /**
     * Combine the find() and paginate into one function
     * @throws Exception
     * @param string $model : The model to query
     * @param number $option['limit'] : Limit of the query
     * @param array $option['select'] : Fields of the query
     * @param array $option['where'] : Conditions of the query
     * @param array $option['order'] : Order of the query
     * @param array $option['contain'] : contain of the query
     * @return $query 
     */
    public function query($model,$option=null)
    {
        $this->loadModel($model);
        
        /* ---------- Set limit { ---------- */
        $limit = null;
        if(isset($_GET['limit']) && is_numeric($_GET['limit']))
        {
            $limit = $_GET['limit'];
        }
        else if(isset($option['limit']))
        {
            $limit = $option['limit'];
        }
        /* ---------- Set limit } ---------- */
        
        /* ---------- Set joins { ---------- */
        /* ---------- Set joins } ---------- */
        
        /* ---------- Set select { ---------- */
        $select = [];
        if(isset($_GET['select']))
        {
            $select = explode(',', $_GET['select']);
        }
        else if(isset($option['select']))
        {
            $select = $option['select'];
        }
        /* ---------- Set select } ---------- */
        
        /* ---------- Set where { ---------- */
        $where = [];
        $fields = $this->getAllFields($model);
        foreach($fields as $field)
        { 
            if(isset($_GET[$field]))
            {
                $value = $_GET[$field];
                
                /* ---------- Prevent ambigus { ---------- */                
                if(strpos($field,'.') !== false){}
                else
                {
                    $field = $model.'.'.$field;
                }
                /* ---------- Prevent ambigus } ---------- */

                // Get operator
                $op = substr($value,0,2);
                if(in_array($op,array('<>','>=','<=')))
                {
                    $value = substr($value,2);
                    $cond = array($field.' '.$op => $value);
                    $where = array_merge($where,$cond);
                }
                else
                {
                    $op = substr($value,0,1);
                    if(in_array($op,array('>','<')))
                    {
                        $value = substr($value,1);
                        
                        $cond = array($field.' '.$op => $value);
                        $where = array_merge($where,$cond);
                    }
                    else
                    {
                        $op = null;
                                                
                        $specialSearch = false;
                        /* ---------- Special query { ---------- */
                        // like
                        $firstChar = substr($value, 0 ,1);
                        $lastChar =  substr($value, -1 ,1);
                        
                        $searchLike = false;
                        
                        if($firstChar == '*')
                        {
                            $searchLike = true;
                            $value = substr($value, 1);
                            $firstChar = '%';
                        }
                        else
                        {
                            $firstChar = '';
                        }
                        
                        if($lastChar == '*')
                        {
                            $searchLike = true;
                            $value = substr($value, 0, strlen($value)-1);
                            $lastChar = '%';
                        }
                        else
                        {
                            $lastChar = '';
                        }
                        
                        if($searchLike)
                        {
                            $specialSearch = true;
                            $cond = array("($field like '$firstChar$value$lastChar')");
                            $where = array_merge($where,$cond);
                        }
                        /* ---------- Special query } ---------- */
                        
                        if($specialSearch == false)
                        {
                            // Normal case => not use $op
                            $cond = array($field => $value);
                            $where = array_merge($where,$cond);
                        }
                    }
                }
            }
        }
        
        if(isset($option['where']))
        {
            $where = array_merge($where,$option['where']);
        }
        /* ---------- Set where } ---------- */
        
        /* ---------- Set order { ---------- */        
        $order = [];
        if(isset($_GET['sort']))
        {
            $sort = $_GET['sort'];
            $direction = 'asc';
            if(isset($_GET['direction']) && ($_GET['direction'] == 'asc' || $_GET['direction'] == 'desc'))
            {
                $direction = $_GET['direction'];
            }
            $order = [$sort=>$direction];
        }
        else if(isset($option['order']))
        {
            $order = $option['order'];
        }
        /* ---------- Set order } ---------- */
        
        /* ---------- Set contain { ---------- */
        $contain = [];
        if(isset($_GET['contain']))
        {
            $arrAssociation = $this->$model->associations()->keys();
            $urlContain = explode(',', $_GET['contain']);
            foreach($urlContain as $many)
            {
                if(in_array($many,$arrAssociation))
                {
                    array_push($contain, $many);
                }
            }
        }
        else if(isset($option['contain']))
        {
            $contain = $option['contain'];
        }
        /* ---------- Set contain } ---------- */
        
        $query = $this->$model->find();
        if($limit) $query->limit($limit);
        if($select) $query->select($select);
        if($where) $query->where($where);
        if($order) $query->order($order);
        if($contain) $query->contain($contain);
        
        if(isset($_GET['paging']) && $_GET['paging'] == true)
        {
            try 
            {
                $query = $this->paginate($query);
            } 
            catch (\Cake\Network\Exception\NotFoundException $e) 
            {
                $this->Output['status'] = API_STATUS_ERROR;
                $this->Output['error_code'] = ERROR_INVALID_PAGE_RANGE;
                $this->writeOutput();
            }
        }
        
        return $query;
    }
    
    function getAllFields($model=null)
    {
        $tableName = $this->$model->table();
        $temp = $this->$model->query("describe $tableName")->first();
        $temp = $temp->toArray();
        
        $fields = array();
        foreach($temp as $field => $value)
        {
            if(is_array($field))
            {
                $field = array_keys($field)[0];
            }
            
            array_push($fields,$field);
        }
        return $fields;
    }
}