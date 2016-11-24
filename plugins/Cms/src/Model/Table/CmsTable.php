<?php
namespace Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cms\Model\Entity\Cm;

/**
 * Cms Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCms
 * @property \Cake\ORM\Association\HasMany $ChildCms
 */
class CmsTable extends Table
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

        $this->table('cms');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->entityClass('Cms.Cms');
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
               
        $validator
            //->requirePresence('name', 'create')
            ->notEmpty('name');
        
        $validator
            ->add('url', 'valid', ['rule' => 'url','message'=>__('Url is invalid')])
            ->allowEmpty('url');

        $validator
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->notEmpty('active');

        return $validator;
    }
}
