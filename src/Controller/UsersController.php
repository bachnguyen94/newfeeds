<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Routing\Router;

/**
 * @property bool layout
 */
class UsersController extends AppController
{

    /**
     * Admin login
     *
     * @return \Cake\Network\Response|void
     */
    public function login()
    {
        $this->viewBuilder()->layout(false);
        if ($this->request->is('post')) {
            $email = $this->request->data['email'];
            $password = Security::hash($this->request->data['password'], 'sha1', true);
            $user = $this->Users->find()->where(['email'=>$email,'password'=>$password,'status <>'=>USER_STATUS_DELETED, 'group' => GROUP_ADMIN])->first();
            if ($user) {
                if($user->status == USER_STATUS_ACTIVE){
                    $user->auth_token = \Core::randomCode();
                    if($this->Users->save($user)) {
                        $this->request->session()->write('Core.Users',$user);
                        $this->Flash->success(__('Welcome '.$user->last_name));
                        return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'index']);
                    }
                }else{
                    $this->Flash->warning(__('Your account has been blocked'));
                }
            } else {
                $this->Flash->error('Invalid email or password');
            }
        }
    }

    function ajax_signup()
    {
        if($this->request->is('ajax'))
        {
            $userEntity = $this->Users->newEntity();
            $userEntity = $this->Users->patchEntity($userEntity, $this->request->data);
            $userEntity->password = Security::hash($userEntity->password, 'sha1', true);
            
            $code = \Core::randomCode();
            $link = Router::url('/', true).'users/account_activation'.$code;
            $userEntity->extra_token = $code;
            
            if($this->Users->save($userEntity))
            {
                /* ---------- Send email { ---------- */
                $option = [
                    'email'=>$userEntity->email,
                    'name'=>$userEntity->first_name . ' ' . $userEntity->last_name,
                    'link'=>$link
                ];

                $this->Core->saveEmailStack(EMAIL_TEMPLATE_SIGNUP,$option);
                /* ---------- Send email } ---------- */
                
                $this->ajax['status'] = AJAX_STATUS_SUCCESS;
                //$this->ajax['redirect'] = 'Config redirect here';
            }
        }
    }
    
    function ajax_login()
    {
        if($this->request->is('ajax'))
        {
            $email = $this->request->data['email'];
            $password = Security::hash($this->request->data['password'], 'sha1', true);
            $user = $this->Users->find()->where(['email'=>$email,'password'=>$password,'status <>'=>USER_STATUS_DELETED])->first();
            
            if($user)
            {
                if($user->status == USER_STATUS_ACTIVE)
                {
                    $user->auth_token = \Core::randomCode();
                    
                    // if 'remember me' checked, save cookie
                    /*if(isset($this->request->data['User']['remember']))
                    {
                        $this->Cookie->write('CookieRemember', $user->auth_token, null, '30 days');
                    }
                    else
                    {
                        $this->Cookie->delete('CookieRemember');
                    }*/
                    
                    if($this->Users->save($user))
                    {
                        $this->request->session()->write('Core.Users',$user);
                        $this->ajax['status'] = AJAX_STATUS_SUCCESS;
                        $this->ajax['redirect'] = $this->request->webroot.'admin/users/index';
                    }
                }
                else
                {
                    $this->ajax['status'] = AJAX_STATUS_ERROR;
                    $this->ajax['error'] = __('Your account has been blocked');
                }
            }
            else
            {
                $this->ajax['status'] = AJAX_STATUS_ERROR;
                $this->ajax['error'] = __('Invalid email or password');
            }
        }
    }
    
    function ajax_forgot()
    {
        if($this->request->is('ajax')) 
        {
            $user = $this->Users->find()->where(['email'=>$this->request->data['email'],'status <>'=>USER_STATUS_DELETED])->first();
            if($user)
            {
                $code = \Core::randomCode();
                $link = Router::url('/', true).'users/reset_password/'.$code;
                $user->extra_token = $code;

                if($this->Users->save($user))
                {
                    /* ---------- Send email { ---------- */
                    $option = array
                    (
                        'email'=>$user->email,                    
                        'name'=>$user->first_name . ' ' . $user->last_name,
                        'link'=>$link
                    );

                    $this->Core->saveEmailStack(EMAIL_TEMPLATE_FORGOT_PASSWORD,$option);
                    /* ---------- Send email } ---------- */
                }
                
                $this->Flash->success(__('Please check email to reset your password'));
                $this->ajax['status'] = AJAX_STATUS_SUCCESS;
                $this->ajax['redirect'] = $this->request->webroot;
            }
            else
            {
                $this->Flash->error(__('Email is not exist in the system'));
                $this->ajax['status'] = AJAX_STATUS_ERROR;
                $this->ajax['redirect'] = $this->request->webroot;
            }
        }
    }
    
    function reset_password($token=null)
    {
        $user = $this->Users->find()->where(['extra_token'=>$token,'status <>'=>USER_STATUS_DELETED])->first();

        if(!$user)
        {
            $this->Flash->error(__('Reset password link is invalid'));
            $this->redirect(['controller'=>'pages','action'=>'index']);
        }
        
        if ($this->request->is('put'))
        {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->password = $user->new_password;
            $user->extra_token = null;
            if($this->Users->save($user))
            {
                $this->Flash->success('Your password has been changed. You can now login to system using new password.');
                $this->redirect(['controller'=>'pages','action'=>'index']);
            }
        }
        
        $this->set(compact('user'));
    }
    
    function logout()
    {
        $this->request->session()->destroy();
        $this->redirect(['controller'=>'pages','action'=>'index']);
    }
}