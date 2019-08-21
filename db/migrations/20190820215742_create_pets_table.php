<?php

use Phinx\Migration\AbstractMigration;

class CreatePetsTable extends AbstractMigration
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
        $this->table('pets')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('category', 'integer', ['signed' => false])
            ->addColumn('status', 'string', ['limit' => 255])
            ->addColumn('photo_urls', 'json')
            ->addIndex(['name'])
            ->addIndex(['status'])
            ->create();
    }
}
