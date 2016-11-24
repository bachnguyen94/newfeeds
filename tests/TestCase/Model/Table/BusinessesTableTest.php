<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BusinessesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BusinessesTable Test Case
 */
class BusinessesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BusinessesTable
     */
    public $Businesses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.businesses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Businesses') ? [] : ['className' => 'App\Model\Table\BusinessesTable'];
        $this->Businesses = TableRegistry::get('Businesses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Businesses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
