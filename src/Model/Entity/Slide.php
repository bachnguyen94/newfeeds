<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Slide Entity
 *
 * @property int $id
 * @property string $table_name
 * @property string $imageUrl
 * @property string $title
 * @property string $description
 * @property int $recordId
 * @property int $display_order
 * @property int $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Business[] $businesses
 * @property \App\Model\Entity\Fashion[] $fashions
 * @property \App\Model\Entity\Game[] $games
 * @property \App\Model\Entity\Photography[] $photographies
 * @property \App\Model\Entity\Technology[] $technologies
 */
class Slide extends Entity
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
}
