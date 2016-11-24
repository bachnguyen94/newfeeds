<?php
namespace Cms\Controller;
use Cms\Controller\AppController;

/**
 * Cms Controller
 *
 * @property \Cms\Model\Table\CmsTable $Cms
 */
class CmsController extends AppController
{
    public function index($id=null)
    {
        $this->layout = 'Admin.default';
        
        if($id)
        {
            $cms = $this->Cms->find('children',['for'=>$id])->find('threaded');
            $crumbs = $this->Cms->find('path', ['for' => $id]);
            $this->set('crumbs',$crumbs);
        }
        else
        {
            $cms = $this->Cms->find('threaded',['order'=>'display_order']);
        }
        
        
        $this->set('cms', $cms);
    }

    public function add($id=null)
    {
        $this->layout = 'Admin.default';
        $cms = $this->Cms->newEntity();
        
        if ($this->request->is('post')) 
        {
            $cms = $this->Core->patchEntity($cms, $this->request->data);
            
            $cms->slug = \Core::toSlug($cms->name);
            if ($this->Cms->save($cms)) 
            {
                $this->Flash->success(__('The cms has been saved'),['plugin'=>'Admin']);
                return $this->redirect(['plugin'=>'admin','action' => 'index',$cms->parent_id]);
            } 
            else 
            {
                $this->Flash->error(__('The cms could not be saved'),['plugin'=>'Admin']);
            }
        }
        
        $listParent = $this->Cms->find('treeList');
        $this->set(compact('cms','listParent'));
    }
    
    public function edit($id=null)
    {
        $this->layout = 'Admin.default';
        $cms = $this->Cms->newEntity();
        
        if($id) // Edit method
        {
            $cms = $this->Cms->get($id);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $cms = $this->Core->patchEntity($cms, $this->request->data);
            $cms->slug = \Core::toSlug($cms->name);
            if ($this->Cms->save($cms)) 
            {
                $this->Flash->success(__('The cms has been saved'),['plugin'=>'Admin']);
                return $this->redirect(['plugin'=>'admin','action' => 'index',$cms->parent_id]);
            } 
            else 
            {
                $this->Flash->error(__('The cms could not be saved'),['plugin'=>'Admin']);
            }
        }
        
        $listParent = $this->Cms->find('treeList');
        $this->set(compact('cms','listParent'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cm id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cms = $this->Cms->get($id);
        if ($this->Cms->delete($cms)) {
            $this->Flash->success(__('The cms has been deleted'),['plugin'=>'Admin']);
        } else {
            $this->Flash->error(__('The cms could not be deleted'),['plugin'=>'Admin']);
        }
        return $this->redirect(['plugin'=>'admin','action' => 'index',$cms->parent_id]);
    }
    
    public function view()
    {
        $args = func_get_args(); 
        $slug = end($args);
        
        $cms = $this->Cms->find()->where(['slug'=>$slug,'active'=>true])->first();
        if(!$cms)
        {
            $this->Flash->error(__('Page could not be found'));
            $url = \Cake\Routing\Router::url('/', true);
            header("Location: $url"); exit; // Need this to force redirect
        }
        
        $this->set('cms', $cms);
    }
}
