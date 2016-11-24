<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Photography Entity
 *
 * @property int $id
 * @property string $imageUrl
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Photography extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    public $imageFields = [
        'imageUrl' => [
            'size' => 3145728, //3*1024*1024 B
            'extensions' => ['Jpg', 'Png'],
            'required' => true,
            'multiple' => true
        ],
        'test_field_image' => [
            'size' => 100000,
            'extensions' => ['jpg', 'png'],
            'required' => false
        ]
    ];
}
