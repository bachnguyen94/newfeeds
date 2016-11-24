<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Facebooks
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Menus', [
            'foreignKey' => 'user_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('password', 'create')
            ->add('password', 'length', ['rule' => ['minLength', 6]])
            ->notEmpty('password');
        $validator
            ->add('password_confirm', 'no-misspelling', [
                'rule' => ['compareWith', 'password'],
                'message' => 'Passwords are not equal'
            ])
            ->notEmpty('password');

        $validator
            ->allowEmpty('first_name');

        $validator
            ->allowEmpty('last_name');

        /*
        $validator
            ->add('group', 'valid', ['rule' => 'numeric'])
            ->requirePresence('group', 'create')
            ->notEmpty('group');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');
         */

        $validator
            ->notEmpty('old_password');
        $validator
            ->add('new_password', 'length', ['rule' => ['minLength', 6]])
            ->notEmpty('new_password');
        $validator
            ->add('new_password_confirm', 'no-misspelling', [
                'rule' => ['compareWith', 'new_password'],
                'message' => 'Passwords are not equal'
            ])
            ->notEmpty('new_password_confirm');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {

        $rules->add($rules->isUnique(['email'],__('Email is already exist')));
        return $rules;
    }
    
    public function beforeSave(Event $event, Entity $entity)
    {
        // Not hash here anymore because cannot catch the ['new']
        //$entity->password = Security::hash($entity->password, 'sha1', true);
    }

    /**
     * Copy user auths
     * @param $fromGroup
     * @param $toGroup
     */
    public function copyAuths($fromGroup, $toGroup)
    {
        $this->UserAuths = TableRegistry::get('UserAuths');
        $allUserAuths = $this->UserAuths->find()->where(['group' => $fromGroup]);
        $this->UserAuths->deleteAll(['group' => $toGroup]);

        foreach ($allUserAuths as $auth) {
            unset($auth['id']);
            $auth['group'] = $toGroup;
            if (!$auth['parent_id']) {
                unset($auth['parent_id']);
            }

            //save new menu
            $newAuthEntity = $this->UserAuths->newEntity();
            $newAuth = $this->UserAuths->patchEntity($newAuthEntity, $auth->toArray());
            $result = $this->UserAuths->save($newAuth);
            if (!$result) {
                debug($newAuth);
                die('Save new menu error!');
            };
        }
    }
}