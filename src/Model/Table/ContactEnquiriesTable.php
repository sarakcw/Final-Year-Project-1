<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactEnquiries Model
 *
 * @method \App\Model\Entity\ContactEnquiry newEmptyEntity()
 * @method \App\Model\Entity\ContactEnquiry newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactEnquiry> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContactEnquiry get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContactEnquiry findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContactEnquiry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactEnquiry> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContactEnquiry|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContactEnquiry saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContactEnquiry>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactEnquiry>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactEnquiry>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactEnquiry> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactEnquiry>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactEnquiry>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactEnquiry>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactEnquiry> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ContactEnquiriesTable extends Table
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

        $this->setTable('contact_enquiries');
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
            ->scalar('first_name')
            ->maxLength('first_name', 50)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name', 'First name is required');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50)
            ->allowEmptyString('last_name');

        $validator
            ->email('email', false, 'Please enter a valid email address')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 10, 'Please enter a valid phone number')
            ->minLength('phone_number', 10, 'Please enter a valid phone number')
            ->allowEmptyString('phone_number');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message')
            ->maxLength('message', 500, 'Message cannot be longer than 500 characters.');

        $validator
            ->dateTime('date_sent')
            ->allowEmptyDateTime('date_sent');

        $validator
            ->scalar('replied')
            ->inList('replied', ['replied', 'not replied'], 'Please select a valid reply status')
            ->notEmptyString('replied', 'Reply status is required');

        return $validator;
    }
}
