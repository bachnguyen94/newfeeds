<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Slides Model
 *
 * @property \Cake\ORM\Association\HasMany $Businesses
 * @property \Cake\ORM\Association\HasMany $Fashions
 * @property \Cake\ORM\Association\HasMany $Games
 * @property \Cake\ORM\Association\HasMany $Photographies
 * @property \Cake\ORM\Association\HasMany $Technologies
 *
 * @method \App\Model\Entity\Slide get($primaryKey, $options = [])
 * @method \App\Model\Entity\Slide newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Slide[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Slide|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Slide patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Slide[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Slide findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SlidesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('slides');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Businesses', [
            'className' => 'Businesses',
            'foreignKey' => 'recordId',
            'conditions' => ['Slides.table_name' => 'Businesses'],
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Fashions', [
            'className' => 'Fashions',
            'foreignKey' => 'recordId',
            'conditions' => ['Slides.table_name' => 'Fashions'],
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Games', [
            'className' => 'Games',
            'foreignKey' => 'recordId',
            'conditions' => ['Slides.table_name' => 'Games'],
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Photographies', [
            'className' => 'Photographies',
            'foreignKey' => 'recordId',
            'conditions' => ['Slides.table_name' => 'Photographies'],
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Technologies', [
            'className' => 'Technologies',
            'foreignKey' => 'recordId',
            'conditions' => ['Slides.table_name' => 'Technologies'],
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('table_name', 'create')
            ->notEmpty('table_name');

        $validator
            ->requirePresence('imageUrl', 'create')
            ->notEmpty('imageUrl');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->integer('recordId')
            ->requirePresence('recordId', 'create')
            ->notEmpty('recordId');

        $validator
            ->integer('display_order')
            ->requirePresence('display_order', 'create')
            ->notEmpty('display_order');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
}
