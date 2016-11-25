<?php
/**
 * Created by PhpStorm.
 * User: nguyenxuanbach
 * Date: 11/23/2016
 * Time: 4:24 PM
 */

namespace App\Controller\Component;

use Cake\Controller\Component;

class OrderComponent extends Component
{
    public function orderSlide($request = null,$cur_order = null){
        if($request && !$cur_order){ //thêm

        }
        if($request && $cur_order){ //đổi vị trí

        }
        if(!$request && $cur_order){ // xóa

        }
    }
}