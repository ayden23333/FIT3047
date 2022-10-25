<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customer Model
 *
 * @method \App\Model\Entity\Customer newEmptyEntity()
 * @method \App\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomerTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('customer');
        $this->setDisplayField('Customer_ID');
        $this->setPrimaryKey('Customer_ID');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('Customer_Firstname')
            ->maxLength('Customer_Firstname', 63)
            ->requirePresence('Customer_Firstname', 'create')
            ->notEmptyString('Customer_Firstname');

        $validator
            ->scalar('Customer_Lastname')
            ->maxLength('Customer_Lastname', 63)
            ->requirePresence('Customer_Lastname', 'create')
            ->notEmptyString('Customer_Lastname');

        $validator
            ->integer('Customer_password')
            ->requirePresence('Customer_password', 'create')
            ->notEmptyString('Customer_password');

        $validator
            ->scalar('Customer_email')
            ->maxLength('Customer_email', 63)
            ->requirePresence('Customer_email', 'create')
            ->notEmptyString('Customer_email');

        $validator
            ->integer('Cus_phone')
            ->requirePresence('Cus_phone', 'create')
            ->notEmptyString('Cus_phone');

        $validator
            ->scalar('Cus_Street')
            ->maxLength('Cus_Street', 63)
            ->requirePresence('Cus_Street', 'create')
            ->notEmptyString('Cus_Street');

        $validator
            ->scalar('Cus_City')
            ->maxLength('Cus_City', 63)
            ->requirePresence('Cus_City', 'create')
            ->notEmptyString('Cus_City');

        $validator
            ->scalar('Cus_State')
            ->maxLength('Cus_State', 3)
            ->requirePresence('Cus_State', 'create')
            ->notEmptyString('Cus_State');

        $validator
            ->integer('Cus_postcode')
            ->requirePresence('Cus_postcode', 'create')
            ->notEmptyString('Cus_postcode');

        return $validator;
    }
}
