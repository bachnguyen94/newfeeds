<?php
use Migrations\AbstractMigration;

class Slides extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('slides');
        $table->addColumn('table_name', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('imageUrl', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('recordId', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('display_order', 'integer', [
            'default' => null,
        ]);
        $table->addColumn('status', 'integer', [
            'default' => 1
        ]);
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
    public function down()
    {
        $this->dropTable('slides');
    }
}
