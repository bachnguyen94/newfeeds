<?php
namespace App\Test\TestCase\Shell;

use App\Shell\OneMinuteShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\OneMinuteShell Test Case
 */
class OneMinuteShellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');
        $this->OneMinute = new OneMinuteShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OneMinute);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
