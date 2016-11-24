<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @property null layout
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function index()
    {

        $businesses = $this->loadModel('Businesses');
        $fashions = $this->loadModel('Fashions');
        $technologies = $this->loadModel('Technologies');
        $photographies = $this->loadModel('Photographies');
        $games = $this->loadModel('Games');


        // This is homepage
        $this->paginate = ['limit'=>2];
        $this->buildAjaxMore('Menus','ajax_more','list',['container'=>'#divMore','link'=>'.hw-ajax-more']);

        //load slide
        $slides = $this->loadModel('Slides');
        $arrEntity = array();
        $slide_entities = $this->Slides->find('all')->where(['status' => 1])->order(['display_order'=>'ASC']);
        $arrEntity['slide_entities'] = $slide_entities;
        $str = "record"; $i = 0;
        foreach ($slide_entities as $slide_entity){
            ${$str.$i} = $this->{$slide_entity->table_name}->get($slide_entity->recordId);
            $this->compact_slide($str.$i,${$str.$i},$arrEntity);
            $i++;
        }
        // end slide


        //load lastest post
        $arr_lastest_post = array();
        $lastest_business = $this->Businesses->find()->limit(1)->first();
        array_push($arr_lastest_post,$lastest_business);
        $lastest_game = $this->Games->find()->limit(1)->first();
        array_push($arr_lastest_post,$lastest_game);
        $lastest_photography = $this->Photographies->find()->limit(1)->first();
        array_push($arr_lastest_post,$lastest_photography);
        $lastest_technology = $this->Technologies->find()->limit(1)->first();
        array_push($arr_lastest_post,$lastest_technology);
        $lastest_fashion = $this->Fashions->find()->limit(1)->first();
        array_push($arr_lastest_post,$lastest_fashion);

        $this->compact_slide('lastestposts',$arr_lastest_post,$arrEntity);


        $arrModel = [$businesses,$fashions,$technologies,$games];

        $photography = $photographies->find()->select('imageUrl','title')->order(['id'=>'DESC'])->limit(6);
        $this->compact($photographies,$photography,$arrEntity);
        $this->queryIndex($arrModel,5,$arrEntity);
        $this->set($arrEntity);

    }
    public function queryIndex($arrModel,$limit,&$arrEntity){
        foreach($arrModel as $Arr){
            $entity = $Arr->find()->order(['id'=>'DESC'])->limit($limit)->toArray();
            $this->compact($Arr,$entity,$arrEntity);
        }
    }
    public function compact($model,$entity,&$arrEntity){
        $arrEntity[lcfirst($model->alias())] = $entity;
    }

    public function compact_slide($str,$entity,&$arrEntity){
        $arrEntity[$str] = $entity;
    }

    public function cake()
    {
        // This is default action of cake to check configuration
    }

    public function change_language($lang)
    {
        $this->request->session()->write('Config.language', $lang);
        I18n::locale($lang);
        $this->redirect($this->referer());
    }
}
