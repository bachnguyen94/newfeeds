<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Core\Configure;
use Phinx\Config\Config;

/**
 * Slides Controller
 *
 * @property \Admin\Model\Table\SlidesTable $Slides
 */
class SlidesController extends AppController
{
    public $helpers = [
        'Paginator'
    ];
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->loadModel('Businesses');
        $this->loadModel('Fashions');
        $this->loadModel('Games');
        $this->loadModel('Slides');
        $this->loadComponent('Paginator');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $slides = $this->paginate($this->Slides);
        // danh sách thứ tự slide
        $orders = $this->Slides->find('list',[
            'keyField' => 'display_order',
            'valueField' => 'display_order'
        ])->toArray();
        //danh sách status
        $status = $this->Slides->find('list',[
            'keyField' => 'status',
            'valueField' => 'status'
        ])->toArray();
        $arr_table = array();
        $slides = $this->Slides->find('all')->select(['recordId','table_name','display_order'])->order(['display_order'=>'ASC'])->toArray();
        foreach ($slides as $slide){
            $tmp = $this->{$slide->table_name}->get($slide->recordId);
            array_push($arr_table,$tmp);
        }

        $this->set(compact('slides','orders','status','arr_table'));
        $this->set('_serialize', ['slides']);
    }
    public function getAjax(){
        $data = $this->request->data['model_index'];
        $table_name = Configure::read('Core.Tablename')[$data];

        $records = $this->$table_name->find('list',[
            'keyField' => 'id',
            'valueField' => 'title'
        ])->where([$table_name.'.slide_id' =>  0])->toArray();



        echo json_encode($records);die;
    }
    public function form($id = null){
        $orders = $this->Slides->find('list',[
            'keyField' => 'display_order',
            'valueField' => 'display_order'
        ])->toArray();
        $slide = $this->Slides->newEntity();
        if($id){
            $slide = $this->Slides->get($id);
        }
        if($this->request->data){

            // lấy ra bảng đã chọn

            $data = $this->request->data['table_name'];
            $table_name = Configure::read('Core.Tablename')[$data];

            $count_slide = $this->Slides->find('all')->count();
            $order = $this->request->data['display_order'];
            //chọn record theo id rồi lưu lại
            $record = $this->$table_name->get($this->request->data['recordId']);
            $slide->table_name = $table_name;
            $slide->imageUrl = $record->imageUrl;
            $slide->description = $record->description;
            $slide->recordId = $this->request->data['recordId'];
            $slide->title = $record->title;
            if($order == null){
                $order = $count_slide + 1;
            }
            else{
                //nếu tìm thấy record bị chèn thứ tự thì tăng các record phía sau thêm 1
                for($i = $order; $i <= $count_slide;$i++){
                    $record_add = $this->Slides->find()->where(['display_order' => $i])->first();
                    $record_add->display_order = $i+1;
                    $this->Slides->save($record_add);
                }
            }
            $slide->display_order = $order;
            // nếu là form sửa

            if($this->Slides->save($slide)){
                $record = $this->$table_name->get($this->request->data['recordId']);
                $record->slide_id = $slide->id;
                $this->$table_name->save($record);
            }
            return $this->redirect(['action' => 'index']);

        }
        $this->set(compact('slide','orders'));
    }
    public function compact($str,$entity,&$arrEntity){
        $arrEntity[$str] = $entity;
    }

    /**
     * View method
     *
     * @param string|null $id Slide id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $slide = $this->Slides->get($id, [
            'contain' => []
        ]);

        $this->set('slide', $slide);
        $this->set('_serialize', ['slide']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $slide = $this->Slides->newEntity();
        if ($this->request->is('post')) {
            $slide = $this->Slides->patchEntity($slide, $this->request->data);
            if ($this->Slides->save($slide)) {
                $this->Flash->success(__('The slide has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The slide could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('slide'));
        $this->set('_serialize', ['slide']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Slide id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $slide = $this->Slides->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $slide = $this->Slides->patchEntity($slide, $this->request->data);
            if ($this->Slides->save($slide)) {
                $this->Flash->success(__('The slide has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The slide could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('slide'));
        $this->set('_serialize', ['slide']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Slide id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $slide = $this->Slides->get($id);
        $table = $this->loadModel($slide->table_name);
        $entity = $table->get($slide->recordId);
        $entity->slide_id = 0;

        $order = $slide->display_order;
        $count_slide = $this->Slides->find('all')->count();
        for($i = $order + 1; $i <= $count_slide;$i++){
            $record_add = $this->Slides->find()->where(['display_order' => $i])->first();
            $record_add->display_order = $i - 1;
            $this->Slides->save($record_add);
        }

        if ($this->Slides->delete($slide)) {
            $table->save($entity);
            $this->Flash->success(__('The slide has been deleted.'));
        } else {
            $this->Flash->error(__('The slide could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        $this->autoRender = false; // action không cần view
        $order = (int)$this->request->data['display_order'];
        $id = (int)$this->request->data['id'];
        $cur_order = $this->Slides->get($id)->display_order;

        //tiến hành cập nhật thứ tụ
        $i = ($order > $cur_order)? 1 : -1;
        $range = range($order,$cur_order + $i);
        $arr_model = array();
        foreach ($range as $value){
            $slide = $this->Slides->find()->where(['display_order' => $value])->first();
            $slide->display_order = $value - $i;
            array_push($arr_model,$slide);
        }
        $this->Slides->saveMany($arr_model);


        $swap = $this->Slides->get($id);
        $swap->display_order = $order;
        $this->Slides->save($swap);
        echo json_encode(['status' => 201]);
    }
    public function getStatus(){
        $this->autoRender = false; // action không cần view
        $id = (int)$this->request->data['id'];
        $status = (int)$this->request->data['status'];
        $slide = $this->Slides->get($id);
        $slide->status = $status;
        if($this->Slides->save($slide)){
            $this->Flash->success(__('The status has been save.'));
        } else {
            $this->Flash->error(__('Errors, try again.'));
        }
        echo json_encode(['status' => 201]);
    }
}



