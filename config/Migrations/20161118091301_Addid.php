<?php
use Migrations\AbstractMigration;

class Addid extends AbstractMigration
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
        $table = $this->table('fashions');
        $table->addColumn('slide_id', 'integer')
            ->update();

        $table = $this->table('businesses');
        $table->addColumn('slide_id', 'integer')
            ->update();

        $table = $this->table('technologies');
        $table->addColumn('slide_id', 'integer')
            ->update();

        $table = $this->table('photographies');
        $table->addColumn('slide_id', 'integer')
            ->update();

        $table = $this->table('games');
        $table->addColumn('slide_id', 'integer')
            ->update();
    }
}
