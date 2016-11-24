<?php
namespace Page\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;

/**
 * Page helper
 */
class PageHelper extends Helper
{
    public $helpers = ['Html','Url'];
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    /**
     * Build routing nice link for Page Plugin
     * @throws Exception
     * @param string $name : des
     * @return void
     */
    public function link($code)
    {
        echo $this->Html->link(Configure::read('Core.Pages.'.$code),'/page/'.$code);
    }
}