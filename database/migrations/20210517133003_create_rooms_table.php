<?php

use CQ\DB\Migration;

final class CreateRoomsTable extends Migration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $rooms = $this->table('rooms', ['id' => false, 'primary_key' => 'id']);
        $rooms->addColumn('id', 'uuid')
            ->addColumn('description', 'text')
            ->addColumn('price_monthly', 'float', ['null' => true])
            ->addColumn('size_m2', 'integer', ['null' => true])
            ->addColumn('address', 'string', ['limit' => 256, 'null' => true])
            ->addColumn('published_at', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
