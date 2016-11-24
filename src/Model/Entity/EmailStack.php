<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailStack Entity.
 */
class EmailStack extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'subject' => true,
        'content' => true,
        'sent' => true,
    ];
}
