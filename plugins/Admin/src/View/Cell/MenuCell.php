<?php
namespace Admin\View\Cell;

use Cake\View\Cell;

/**
 * Menu cell
 */
class MenuCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->getMenus();
    }
    
    public function getMenus()
    {
        $this->loadModel('Menus');
        $parents = $this->Menus->find()->where(['OR' => [['parent_id is' => null], ['parent_id' => 0]], 'display' => true])->order('display_order')->toArray();
        $menus = $this->generateMenu($parents);

        foreach ($parents as $key => $parent) {
            $childs = $this->Menus->find()->where(['parent_id' => $parent->id, 'display' => true])->order('display_order')->toArray();
            if($childs) {
                $childs = $this->generateMenu($childs);
                $menus[$parent->name]['child'] = $childs;
            }
        }

        $this->set(compact('menus'));
    }

    /**
     * @param $menusIn
     * @return mixed
     * @internal param $parent
     * @internal param $menus
     * @internal param $key
     */
    public function generateMenu($menusIn)
    {
        $menusOut = [];
        foreach ($menusIn as $key => $menu) {
            $url = [];
            if($menu['controller'] && $menu['action']) {
                $url = [
                    'plugin'     => $menu['plugin'] ? $menu['plugin'] : null,
                    'controller' => $menu['controller'],
                    'action'     => $menu['action'],
                    'param'      => $menu['param']
                ];
            }

            $menusOut[$menu['name']] = [
                'icon'   => $menu['icon'],
                'groups' => $menu['group'],
                'url'    => $url,
                'highlight'    => $menu['highlight'],
            ];
        }

        return $menusOut;
    }
}
