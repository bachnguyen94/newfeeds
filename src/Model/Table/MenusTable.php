<?php
namespace App\Model\Table;

use App\Model\Entity\Menu;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \Cake\ORM\Association\HasMany $ChildMenus
 */
class MenusTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('menus');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('ParentMenus', [
            'className' => 'Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Menus',
            'foreignKey' => 'parent_id'
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
            ->requirePresence('action', 'create')
            ->notEmpty('action');
            
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));
        return $rules;
    }

    /**
     * copy menu from a group to other group
     * @param $fromGroup
     * @param $toGroup
     */
    public function copyMenu($fromGroup, $toGroup){

        $menus = $this->find()->where(['group' => $fromGroup])->order(['parent_id' => 'asc'])->toArray();
        $this->deleteAll(['group' => $toGroup]);
        $listParentIds = [];
        foreach ($menus as $menu) {
            $oldId = $menu['id'];
            unset($menu['id']);
            $menu['group'] = $toGroup;
            if (!$menu['parent_id']) {
                unset($menu['parent_id']);
            } else {
                //check new parent_id
                if (isset($listParentIds[$menu['parent_id']])) {
                    $menu['parent_id'] = $listParentIds[$menu['parent_id']];
                }
            }

            //save new menu
            $newMenuEntity = $this->newEntity();
            $newMenu = $this->patchEntity($newMenuEntity, $menu->toArray());
            $result = $this->save($newMenu);
            if (!$result) {
                debug($newMenu);
                die('Save new menu error!');
            };
            $listParentIds[$oldId] = $result->id;
        }
    }
}
