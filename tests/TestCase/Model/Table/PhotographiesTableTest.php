<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PhotographiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PhotographiesTable Test Case
 */
class PhotographiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PhotographiesTable
     */
    public $Photographies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.photographies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Photographies') ? [] : ['className' => 'App\Model\Table\PhotographiesTable'];
        $this->Photographies = TableRegistry::get('Photographies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Photographies);

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
