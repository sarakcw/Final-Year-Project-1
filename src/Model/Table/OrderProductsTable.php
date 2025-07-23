<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderProducts Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\OrderProduct newEmptyEntity()
 * @method \App\Model\Entity\OrderProduct newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderProduct[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderProduct get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderProduct findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderProduct[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderProduct|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderProduct saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 */
class OrderProductsTable extends Table
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

        $this->setTable('orders_products');
        $this->setPrimaryKey(['order_id', 'product_id']);

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
        ]);
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
            ->integer('order_id')
            ->notEmptyString('order_id');

        $validator
            ->integer('product_id')
            ->notEmptyString('product_id');

        $validator
            ->integer('quantity')
            ->notEmptyString('quantity')
            ->greaterThan('quantity', 0, __('Quantity must be greater than 0'));

        $validator
            ->decimal('price')
            ->notEmptyString('price')
            ->greaterThan('price', 0, __('Price must be greater than 0'));

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('order_id', 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn('product_id', 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
} 