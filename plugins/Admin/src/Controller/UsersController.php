<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Users Controller
 *
 * @property bool layout
 * @property bool|object CurUser
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        parent::index();
        $users = $this->paginate('Users');
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @param null $id
     * @return \Cake\Network\Response|void
     */
    public function form($id = null)
    {
        $user = $this->Users->newEntity()->accessible('email', true)->accessible('group', true)->accessible('status', true);

        if($id) 
        { // if edit method
            $user = $this->Users->get($id)->accessible('group', true)->accessible('status', true);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {               
            $user = $this->Core->patchEntity($user, $this->request->data);

            if ($this->Users->save($user))
            {                                
                $this->Flash->success(__('The user has been saved'), ['plugin' => 'Admin']);
                return $this->redirect(['action' => 'index']);
            } 
            else 
                {
                $this->Flash->error(__('The user could not be saved'), ['plugin' => 'Admin']);
            }
        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted'), ['plugin' => 'Admin']);
        } else {
            $this->Flash->error(__('The user could not be deleted'), ['plugin' => 'Admin']);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function logout()
    {
        $this->request->session()->destroy();
        $this->redirect(['plugin' => null, 'controller'=>'users','action'=>'login']);
    }

    /**
     * profile of the current user login
     *
     * @return \Cake\Network\Response|void
     */
    public function profile()
    {
        $user = $this->Users->get($this->CurUser->id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Core->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved'), ['plugin' => 'Admin']);
                return $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error(__('The user could not be saved'), ['plugin' => 'Admin']);
            }
        }
        
        $this->set(compact('user'));
    }

    /**
     * Update the password
     *
     * @return \Cake\Network\Response|void
     */
    public function change_password()
    {
        $user = $this->Users->get($this->CurUser->id);

        if($this->request->is(['patch', 'post', 'put']))
        {
            $oldPass = $this->request->data['old_password'];
            $oldPassHash = Security::hash($oldPass, 'sha1', true);

            if($oldPass && $oldPassHash != $user->password) 
            {
                $user->errors('old_password', [__('The current password incorrect')]);
                $this->Flash->error(__('The password could not be changed'), ['plugin' => 'Admin']);
            } 
            else 
            {
                $user->password = $this->request->data['new_password'];
                $user = $this->Users->patchEntity($user, $this->request->data);
                
                if ($this->Users->save($user)) 
                {
                    $this->Flash->success(__('The password has been changed'), ['plugin' => 'Admin']);
                    return $this->redirect(['action' => 'change_password']);
                } 
                else 
                {                    
                    $this->Flash->error(__('The password could not be changed'), ['plugin' => 'Admin']);
                }
            }
        }

        $this->set(compact('user'));
    }

    public function set_theme()
    {
        $this->viewBuilder()->layout(false);
        $this->autoRender = false;

        $theme = $this->request->query['theme'];
        $user = $this->Users->get($this->CurUser->id);
        $user->smart_admin_themes = $theme;
        $status = true;

        if (!$this->Users->save($user)) {
            $status = false;
        } else {
            $this->CurUser->smart_admin_themes = $theme;
            $this->request->session()->write('Core.Users', $user);
        }

        echo json_encode(['status' => $status]);
    }
}
