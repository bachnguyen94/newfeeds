<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Photographies Controller
 *
 * @property \Admin\Model\Table\PhotographiesTable $Photographies
 */
class PhotographiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->loadModel('Photographies');
    }

    public function index()
    {
        $photographies = $this->paginate($this->Photographies);

        $this->set(compact('photographies'));
        $this->set('_serialize', ['photographies']);
    }

    /**
     * View method
     *
     * @param string|null $id Photography id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photography = $this->Photographies->get($id, [
            'contain' => []
        ]);

        $this->set('photography', $photography);
        $this->set('_serialize', ['photography']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $photography = $this->Photographies->newEntity();
        if ($this->request->is('post')) {
            $photography = $this->Core->patchEntity($photography, $this->request->data);
            if ($this->Photographies->save($photography)) {
                $this->Flash->success(__('The photography has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The photography could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('photography'));
        $this->set('_serialize', ['photography']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Photography id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photography = $this->Photographies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photography = $this->Photographies->patchEntity($photography, $this->request->data);
            if ($this->Photographies->save($photography)) {
                $this->Flash->success(__('The photography has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The photography could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('photography'));
        $this->set('_serialize', ['photography']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Photography id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photography = $this->Photographies->get($id);
        if ($this->Photographies->delete($photography)) {
            $this->Flash->success(__('The photography has been deleted.'));
        } else {
            $this->Flash->error(__('The photography could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function form($id = null)
    {

        $photography = $this->Photographies->newEntity();
        if($id){
            $photography = $this->Photographies->get($id);
        }

        if ($this->request->data) {
            $photography = $this->Core->patchEntity($photography, $this->request->data);
            if ($this->Photographies->save($photography)) {
                $this->Flash->success(__('The Photographies has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The Photographies could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('photography'));
        $this->set('_serialize', ['photography']);
    }
}