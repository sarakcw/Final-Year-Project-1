<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @method \App\Model\Entity\Product newEmptyEntity()
 * @method \App\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Product> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Product findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Product> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', "Please enter the name of the wine.")
            ->add('name',
                'unique', ['rule' => 'validateUnique', 'provider' => 'table',
                    'message' => "This wine already exists. Please enter a different wine."]);

        $validator
            ->integer('stock_quantity')
            ->greaterThanOrEqual('stock_quantity',0,'Please enter a positive number')
            ->notEmptyString('stock_quantity', 'Please enter the quantity of the wine.');

        $validator
            ->decimal('price')
            ->greaterThanOrEqual('price',0,'Please enter a positive number')
            ->requirePresence('price', 'create')
            ->notEmptyString('price', "PLease enter the price of the wine.");

        $validator
            ->scalar('vintage')
            ->allowEmptyString('vintage')
            ->add('vintage', 'validYear', [
                'rule' => ['custom', '/^\d{4}$/'],
                'message' => 'Please enter a valid year.'
            ]);

        $validator
            ->maxLength('alcohol_content', 5, 'Please enter a valid alcohol content.')
            ->allowEmptyString('alcohol_content');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmptyString('status', "Please select a status.");

        $validator
            ->scalar('region')
            ->maxLength('region', 50, "Please enter valid region of the wine. Region cannot be more than 50 characters.")
            ->requirePresence('region', 'create')
            ->notEmptyString('region', "Please enter the region of the wine.");

        $validator
            ->scalar('style')
            ->maxLength('style', 30)
            ->requirePresence('style', 'create')
            ->notEmptyString('style'. "Please select the style of the wine");

        $validator
            ->allowEmptyFile('image', 'create')

            ->add('image', 'validFormat', [
                'rule' => ['mimeType', ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']],
                'message' => 'Please upload a valid image (PNG, JPG, JPEG, GIF).'
            ])
            ->add('image', 'maxSize', [
                'rule' => ['fileSize', '<=', 2 * 1024 * 1024], // Max size 2MB
                'message' => 'Please upload a file smaller than 2MB.'
            ]);

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);

        return $rules;
    }
}
