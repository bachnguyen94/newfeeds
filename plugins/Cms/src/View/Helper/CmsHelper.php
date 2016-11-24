<?php
namespace Cms\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Cms helper
 */
class CmsHelper extends Helper
{
    public $helpers = ['Html'];
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    
    /**
     * Build the link to the detail page
     * @throws Exception
     * @param string $cms : the cms entity
     * @return void
     */
    public function link($cms,$option=array())
    {
        if($cms->url_popup)
        {
            $option = array_merge($option,['target'=>'_blank']);
        }
            
        if($cms->url)
        {
            return $this->Html->link($cms->name,$cms->url,$option);
        }
        else
        {
            return 'aaa';
        }
    }

}
