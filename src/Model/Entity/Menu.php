<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity.
 */
class Menu extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id'=>true,
        'user_id' => true,
        'parent_id' => true,
        'name' => true,
        'icon' => true,
        'group' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'param' => true,
        'display' => true,
        'display_order' => true,
        'user' => true,
        'parent_menu' => true,
        'child_menus' => true,
    ];
}
