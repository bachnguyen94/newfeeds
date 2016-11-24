<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * CurUser helper
 */
class CurUserHelper extends Helper
{

    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);
        
        /* ---------- Set the current User to $this->CurUser { ---------- */
        $objUser = $this->request->session()->read('Core.Users');
        if(isset($objUser) && !empty($objUser))
        {
            $arrUser = $objUser->toArray();
            $arrProp = array_keys($arrUser);
            foreach($arrProp as $prop)
            {
                $this->{$prop} = $objUser->$prop;
            }
        }
        /* ---------- Set the current User to $this->CurUser } ---------- */
    }
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
}
