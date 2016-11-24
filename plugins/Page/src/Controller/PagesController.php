<?php
namespace Page\Controller;

use Page\Controller\AppController;
use Cake\Core\Configure;

/**
 * Pages Controller
 *
 * @property \Page\Model\Table\PagesTable $Pages
 * @property string layout
 */
class PagesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->updateDB();
        $this->layout = 'Admin.default';
        $this->set('pages', $this->Pages->find()->toArray());
    }
    
    /**
     * Check the setting of static page constant and modify the database
     * @return void
     */
    function updateDB()
    {
        $pageDB = $this->Pages->find()->toArray();
        $pageSetting = array_keys(Configure::read('Core.Pages'));
        
        // Check item to be removed
        foreach($pageDB as $row)
        {
            if(!in_array($row->code,$pageSetting))
            {
                $this->Pages->delete($row);
            }
        }
        
        // Check new item to add
        foreach($pageSetting as $code)
        {
            $isNew = true;
            foreach($pageDB as $row)
            {
                if($code == $row->code)
                {
                    $isNew = false;
                    break;
                }
            }
            
            if($isNew)
            {
                $newEnt = $this->Pages->newEntity();
                $newEnt->code = $code;
                $newEnt->title = Configure::read('Core.Pages.'.$code);
                $this->Pages->save($newEnt);
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->layout = 'Admin.default';
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        $this->set('page', $page);
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->layout = 'Admin.default';
        
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->data);
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The page has been saved'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The page could not be saved'));
            }
        }
        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
    }
            
    /**
     * Show method
     * Show to the front end
     * @param string|null $id Page id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function detail($code = null)
    {
        $page = $this->Pages->find()->where(['code'=>$code])->first();
        $this->set('page', $page);
    }
}
