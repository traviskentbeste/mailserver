<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190128021442 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        // Create 'domain' table
        $table = $schema->createTable('domain');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['notnull' => true, 'length'=>128]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine' , 'InnoDB');

        // Create 'user' table
        $table = $schema->createTable('user');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('domain_id', 'integer', ['notnull' => true, 'default' => 0]);
        $table->addColumn('username', 'string', ['notnull' => true]);
        $table->addColumn('password', 'string', ['notnull' => true]);
        $table->addColumn('status', 'integer', ['notnull' => true, 'default' => 0]);
        $table->addForeignKeyConstraint('domain', ['domain_id'], ['id'], ['onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE']);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine' , 'InnoDB');

        // Create 'alias' table
        $table = $schema->createTable('alias');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => true]);
        $table->addColumn('email', 'string', ['notnull' => true, 'length' => 128]);
        $table->addForeignKeyConstraint('user', ['user_id'], ['id'], ['onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE']);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $schema->dropTable('alias');
        $schema->dropTable('domain');
        $schema->dropTable('user');
    }
}
