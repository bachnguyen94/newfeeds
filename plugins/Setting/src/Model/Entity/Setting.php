<?php
namespace Setting\Model\Entity;

use Cake\ORM\Entity;

/**
 * Setting Entity.
 */
class Setting extends Entity
{
    public $imageFields = [
        'homepage_slide' => [
            'size' => 3145728, //3*1024*1024 B
            'extensions' => ['Jpg', 'Png'],
            'required' => true
        ],
    ];
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
    ];
}
