<?php
namespace Page\Model\Entity;

use Cake\ORM\Entity;

/**
 * Page Entity.
 */
class Page extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'code' => true,
        'title' => true,
        'content' => true,
    ];
}
