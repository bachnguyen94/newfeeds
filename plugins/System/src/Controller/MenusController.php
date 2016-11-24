<?php
namespace System\Controller;

use Cake\Core\Plugin;
use System\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \System\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{

    /**
     * Index method
     *
     * @param null $groupId
     * @return \Cake\Network\Response|void
     * @internal param null $plugin
     */
    public function index($groupId = null)
    {
        if(!$groupId) return $this->redirect(['controller' => 'menus', 'action' => 'index', GROUP_ADMIN]);

        $menus = array();
        $parents = $this->Menus->find()->where(['OR' => [['parent_id is' => null], ['parent_id is' => 0]], 'group' => $groupId])->order(['display_order'])->toArray();
        foreach($parents as $item) {
            $childs = $this->Menus->find()->where(['parent_id' => $item->id, 'group' => $groupId])->order(['display_order'])->toArray();

            if(count($childs) > 0) $item['Child'] = $childs;
            array_push($menus,$item);
        }

        $this->set(compact('menus'));
        $this->set('_serialize', ['menus']);
    }

    /**
     * Add method
     * @param null $groupId
     * @return \Cake\Network\Response|void
     * @internal param null $plugin
     * @internal param null $groupId
     */
    public function add($groupId = null)
    {
        if(!$groupId) return $this->redirect(['controller' => 'menus', 'action' => 'add', GROUP_ADMIN]);
        $listPlugin = $this->convertArray(Plugin::loaded());

        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, array_merge($this->request->data, ['group' => $groupId]));
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved'));
                return $this->redirect(['action' => 'index', $groupId]);
            } else {
                $this->Flash->error(__('The menu could not be saved'));
            }
        }
        $parents = $this->Menus->find('list')->select(['id', 'name'])->where(['OR' => [['parent_id is' => null], ['parent_id is' => 0]], 'group' => $groupId])->order(['display_order'])->toArray();
        $this->set(compact('menu', 'parents', 'groupId', 'listPlugin'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        $listPlugin = $this->convertArray(Plugin::loaded());

        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, array_merge($this->request->data));
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved'));
                return $this->redirect(['action' => 'index', $menu->group]);
            } else {
                $this->Flash->error(__('The menu could not be saved'));
            }
        }

        $parents = $this->Menus->find('list')->select(['id', 'name'])->where(['OR' => [['parent_id is' => null], ['parent_id is' => 0]], 'group' => $menu->group])->order(['display_order'])->toArray();
        $this->set(compact('menu', 'parents', 'listPlugin'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted'));
        } else {
            $this->Flash->error(__('The menu could not be deleted'));
        }
        return $this->redirect(['action' => 'index', $menu->group]);
    }

    /**
     * Set display
     *
     * @param $id
     * @param bool $bool
     */
    public function set_display($id,$bool = true)
    {
        $menu = $this->Menus->get($id);
        $menu->display = $bool;
        $this->Menus->save($menu);
        $this->redirect($this->referer());
    }

    public function sort_parent()
    {
        if(!empty($this->request->data))
        {
            $data = array();
            $i = 1;
            foreach($this->request->data['data']['Order'] as $id)
            {
                $row = array
                (
                    'id'=>$id,
                    'display_order'=>$i
                );
                array_push($data,$row);
                ++$i;
            }
            
            $menus = $this->Menus->newEntities($data);
            $err = 0;
            foreach ($menus as $menu) 
            {
                if(!$this->Menus->save($menu)) {
                    $err++;
                }
            }
            if(!$err) {
                $this->Flash->success(__('Parent has been sorted successfully'));
            }
            $this->redirect($this->referer());
        }
    }

    public function sort_child($menuParentID = null)
    {
        $parent = $this->Menus->find()->where(['id' => $menuParentID])->first()->toArray();
        if(!empty($this->request->data))
        {
            $data = array();
            $i = 1;
            foreach($this->request->data['data']['Order'] as $id)
            {
                $row = array
                (
                    'id'=>$id,
                    'display_order'=>$i
                );
                array_push($data,$row);
                ++$i;
            }
            $menus = $this->Menus->newEntities($data);
            $err = 0;
            foreach ($menus as $menu) {
                if(!$this->Menus->save($menu)) {
                    $err++;
                }
            }
            if(!$err) {
                $this->Flash->success(__('Parent has been sorted successfully'));
            }
            $this->redirect(['controller'=>'menus','action'=>'sort_child', $parent['id']]);
        }

        $menus = $this->Menus->find()->where(['parent_id'=>$menuParentID])->order(['display_order'])->toArray();
        $this->set(compact('menus', 'parent'));
    }

    public function convertArray($array){
        $temp = [];
        foreach($array as $item) {
            $temp = array_merge($temp, [$item => $item]);
        }
        return $temp;
    }
}
