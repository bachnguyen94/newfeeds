<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\BusinessTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\BusinessTable Test Case
 */
class BusinessTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Admin\Model\Table\BusinessTable
     */
    public $Business;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.admin.business'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Business') ? [] : ['className' => 'Admin\Model\Table\BusinessTable'];
        $this->Business = TableRegistry::get('Business', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Business);

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
