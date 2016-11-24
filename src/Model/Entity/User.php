<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Utility\Security;

/**
 * User Entity.
 */
class User extends Entity
{
    public $imageFields = [
        'avatar' => [
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
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*'=>true,
        'facebook_id'=>false,
        'auth_token'=>false,
        'extra_token'=>false,
        'group'=>false,
        'status'=>false
    ];

    protected function _setPassword($password)
    {
        return Security::hash($password, 'sha1', true);
    }
}
