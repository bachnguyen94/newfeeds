<?php
namespace Cms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cm Entity.
 */
class Cms extends Entity
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('cms');
    }
    
    public $imageFields = [
        'icon' => [
            'size' => 1048576, // 1 MB
            'extensions' => ['jpg', 'png'],
            'required' => false
        ],
        'banner' => [
            'size' => 1048576, // 1 MB
            'extensions' => ['jpg', 'png'],
            'required' => false
        ]
    ];
    
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Note that '*' is set to true, which allows all unspecified fields to be
     * mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'icon' => true,
        'icon_tmp' => true  
    ];
}
