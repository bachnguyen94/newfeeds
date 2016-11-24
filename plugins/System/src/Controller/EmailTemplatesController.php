<?php
namespace System\Controller;

use System\Controller\AppController;
use \Cake\Core\Configure;

/**
 * EmailTemplates Controller
 *
 * @property \System\Model\Table\EmailTemplatesTable $EmailTemplates
 */
class EmailTemplatesController extends AppController
{
    public function index($id = null)
    {
        $listTemplate = array_keys(Configure::read('Core.EmailTemplates'));
        if(empty($listTemplate))
        {
            die('Configuration not set. Please config in "config/constant.php" file.');
        }
        
        $this->updateDB();
        
        if(!in_array($id,$listTemplate))
        {
            $this->redirect(['action'=>'index',$listTemplate[0]]);
        }
        else
        {
            $emailTemplate = $this->EmailTemplates->get($id, []);
            
            if ($this->request->is(['patch', 'post', 'put'])) {
                $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->data);
                if ($this->EmailTemplates->save($emailTemplate)) {
                    $this->Flash->success(__('The email template has been saved'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The email template could not be saved'));
                }
            }
            $this->set(compact('emailTemplate'));
            $this->set('_serialize', ['emailTemplate']);
        }
    }
    
    function updateDB()
    {
        $tmpDB = $this->EmailTemplates->find()->toArray();
        $tmpSetting = array_keys(Configure::read('Core.EmailTemplates'));
        
        // Check item to be removed
        foreach($tmpDB as $row)
        {
            if(!in_array($row->id,$tmpSetting))
            {
                $this->EmailTemplates->delete($row);
            }
        }
        
        // Check new item to add
        foreach($tmpSetting as $id)
        {
            $isNew = true;
            foreach($tmpDB as $row)
            {
                if($id == $row->id)
                {
                    $isNew = false;
                    break;
                }
            }
            
            if($isNew)
            {
                $newEnt = $this->EmailTemplates->newEntity();
                $newEnt->id = $id;
                $newEnt->subject = Configure::read('Core.EmailTemplates.'.$id);
                $this->EmailTemplates->save($newEnt);
            }
        }
    }
}
