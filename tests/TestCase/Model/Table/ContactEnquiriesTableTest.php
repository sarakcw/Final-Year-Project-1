<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactEnquiriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactEnquiriesTable Test Case
 */
class ContactEnquiriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactEnquiriesTable
     */
    protected $ContactEnquiries;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ContactEnquiries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ContactEnquiries') ? [] : ['className' => ContactEnquiriesTable::class];
        $this->ContactEnquiries = $this->getTableLocator()->get('ContactEnquiries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactEnquiries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ContactEnquiriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
