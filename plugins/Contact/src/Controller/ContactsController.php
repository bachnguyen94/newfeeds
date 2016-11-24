<?php
namespace Contact\Controller;

use Contact\Controller\AppController;

/**
 * Contacts Controller
 *
 * @property \Contact\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{
    public function index()
    {
        $this->layout = 'Admin.default';
        $this->set('contacts', $this->paginate($this->Contacts));
        $this->set('_serialize', ['contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->layout = 'Admin.default';
        
        $contact = $this->Contacts->get($id);
        $contact->read = true;
        $this->Contacts->save($contact);
        
        $this->set('contact', $contact);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function form()
    {
        $contact = $this->Contacts->newEntity();
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            $contact->ip = $_SERVER['REMOTE_ADDR'];
            
            if ($this->Contacts->save($contact)) 
            {
                $this->Flash->success(__('The contact has been saved'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The contact could not be saved'));
            }
        }
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('The contact has been deleted'),['plugin'=>'Admin']);
        } else {
            $this->Flash->error(__('The contact could not be deleted'),['plugin'=>'Admin']);
        }
        return $this->redirect(['plugin'=>'admin','action' => 'index']);
    }
}
