<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TechnologiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TechnologiesTable Test Case
 */
class TechnologiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TechnologiesTable
     */
    public $Technologies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.technologies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Technologies') ? [] : ['className' => 'App\Model\Table\TechnologiesTable'];
        $this->Technologies = TableRegistry::get('Technologies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Technologies);

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
