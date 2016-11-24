<?php
namespace Contact\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Contact\Model\Entity\Contact;

/**
 * Contacts Model
 *
 */
class ContactsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('contacts');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');
            
        $validator
            ->add('email', 'valid', ['rule' => 'email','message'=>__('Invalid email address')])
            ->notEmpty('email');
            
        $validator
            ->allowEmpty('phone');
            
        $validator
            ->allowEmpty('address');
            
        $validator
            ->add('content', 'length', ['rule' => ['maxLength', 4000],'message'=>__('Max')])
            ->notEmpty('content');

        return $validator;
    }
}
