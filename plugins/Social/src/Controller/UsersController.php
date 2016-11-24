<?php
namespace Social\Controller;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Facebook\FacebookJavaScriptLoginHelper;
use Social\Controller\AppController;

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Cake\Core\Configure;

class UsersController extends AppController
{
    public function facebook_login()
    {
        $fbAppID = Configure::read('System.Facebook.AppID');
        $fbSecret = Configure::read('System.Facebook.AppSecret');
        FacebookSession::setDefaultApplication($fbAppID, $fbSecret);

        $redirectUrl = Router::url(['plugin' => 'Social', 'controller' => 'users', 'action' => 'facebook_login'], true);
        $helper = new FacebookRedirectLoginHelper($redirectUrl);

        try
        {
            $session = $helper->getSessionFromRedirect();
        }
        catch(FacebookRequestException $ex){die('Error get FB session');}
        catch(\Exception $ex){die('Error get FB session');}

        if($session)
        {
            try 
            {
                $user = (new FacebookRequest($session, 'GET', '/me?fields=email,name,id'));
                $user = $user->execute();
                $user = $user->getGraphObject(GraphUser::className());
            } 
            catch(FacebookRequestException $e) 
            {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
            }
        }

        if(isset($user) && $user)
        {
            $fbid = $user->getProperty("id");
            $email = $user->getProperty("email");
            $firstName = $user->getProperty("first_name");
            $lastName = $user->getProperty("last_name");

            $user = $this->Users->find()->where(['facebook_id' => $fbid, 'status <>'=>USER_STATUS_DELETED])->first();

            if($user)
            {
                // Has already login fb before => Allow to login
                $this->request->session()->write('Core.Users',$user);
                $this->redirect(['plugin' => 'admin', 'controller'=>'pages', 'action'=>'index']);
            }
            else
            {
                // Check email exist or not
                $user = $this->Users->find()->where(['email'=>$email,'status <>'=>USER_STATUS_DELETED])->first();
                if($user)
                {
                    //Exist Real account => not allow to login using facebook
                    $this->Flash->success(__('This email exist in the system and cannot be using facebook'));
                    $this->redirect($this->referer());
                }
                else
                {
                    $userEntity = $this->Users->newEntity();
                    
                    $userEntity->email = $email;
                    $userEntity->facebook_id = $fbid;
                    $userEntity->first_name = $firstName;
                    $userEntity->last_name = $lastName;
                    $userEntity->auth_token = \Core::randomCode();
                    $userEntity->status = USER_STATUS_ACTIVE;
                                       
                    if($this->Users->save($userEntity))
                    {
                        $this->request->session()->write('Core.Users', $userEntity);
                        $this->redirect($this->referer());
                    }
                    else
                    {
                        $this->Flash->warning(__('Cannot create member account'));
                        $this->redirect($this->referer());
                    }
                }
            }
        }
        else
        {
            $scope = ['email', 'public_profile'];
            $loginUrl = $helper->getLoginUrl($scope);
            $this->redirect($loginUrl);
        }
    }
}