<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\SlidesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\SlidesTable Test Case
 */
class SlidesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Admin\Model\Table\SlidesTable
     */
    public $Slides;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.admin.slides',
        'plugin.admin.records',
        'plugin.admin.businesses',
        'plugin.admin.fashions',
        'plugin.admin.games',
        'plugin.admin.photographies',
        'plugin.admin.technologies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Slides') ? [] : ['className' => 'Admin\Model\Table\SlidesTable'];
        $this->Slides = TableRegistry::get('Slides', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Slides);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
