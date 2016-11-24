<?php
namespace Api\Controller;

use Api\Controller\AppController;
use Cake\Utility\Security;
use Cake\Routing\Router;

/**
 * Users Controller
 *
 * @property \Api\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    function signup()
    {
        $requestData = $this->getRequestData(['email','password']);
        
        $this->Entity = $this->Users->newEntity();
        $this->Entity = $this->Core->patchEntity($this->Entity, $requestData);
        $this->Entity->password = Security::hash($this->Entity->password, 'sha1', true);
        $this->Entity->group = GROUP_MEMBER;
        $this->Entity->status = USER_STATUS_ACTIVE;

        $code = \Core::randomCode();
        $link = Router::url('/', true).'users/account_activation'.$code;
        $this->Entity->extra_token = $code;

        if($this->Users->save($this->Entity))
        {
            /* ---------- Send email { ---------- */
            $option = [
                'email'=>$this->Entity->email,
                'name'=>$this->Entity->first_name . ' ' . $this->Entity->last_name,
                'link'=>$link
            ];

            $this->Core->saveEmailStack(EMAIL_TEMPLATE_SIGNUP,$option);
            /* ---------- Send email } ---------- */
        }
    }
    
    function login()
    {
        $requestData = $this->getRequestData(['email','password']);
        $email = $requestData['email'];
        $password = Security::hash($requestData['password'], 'sha1', true);
        $user = $this->Users->find()->where(['email'=>$email,'password'=>$password,'status <>'=>USER_STATUS_DELETED])->first();

        if($user)
        {
            if($user->status == USER_STATUS_ACTIVE)
            {
                $user->auth_token = \Core::randomCode();

                if($this->Users->save($user))
                {
                    $this->Output['status'] = API_STATUS_SUCCESS;
                    $this->Output['token'] = $user->auth_token;
                }
            }
            else
            {
                $this->Output['status'] = API_STATUS_ERROR;
                $this->Output['error_code'] = ERROR_EXCEPTION_USER_BLOCK;
            }
        }
        else
        {
            $this->Output['status'] = API_STATUS_ERROR;
            $this->Output['error_code'] = ERROR_EXCEPTION_USER_INVALID;
        }
    }
    
    
    /* ---------- Demo index ---------- */
    public function index()
    {
        $list = $this->query('Users');
        
        $this->Output['status'] = API_STATUS_SUCCESS;
        $this->Output['list'] = $list;
    }

    /* ---------- Demo add ---------- */
    public function add()
    {
        $requestData = $this->getRequestData(['email','password']);
        $this->Entity = $this->Users->newEntity();
        $this->Entity = $this->Core->patchEntity($this->Entity, $requestData);
        
        if ($this->Users->save($this->Entity)) 
        {
            $this->Output['status'] = API_STATUS_SUCCESS;
            $this->Output['id'] = $this->Entity->id;
        }
    }

    /* ---------- Demo delete ---------- */
    public function delete($id = null)
    {
        $requestData = $this->getRequestData(['id']);
        $user = $this->Users->get($requestData['id']);
        if ($this->Users->delete($user))
        {
            $this->Output['status'] = API_STATUS_SUCCESS;
        }
    }
}