<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Customer Addresses Migration
 *
 * @autogenerated
 */
final class Version20200330131156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return "customer address table";
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer_addresses (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, street_name VARCHAR(255) NOT NULL, street_number VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, district VARCHAR(255) DEFAULT NULL, country VARCHAR(2) NOT NULL, phone_number VARCHAR(255) NOT NULL, INDEX IDX_C4378D0CB171EB6C (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_addresses ADD CONSTRAINT FK_C4378D0CB171EB6C FOREIGN KEY (customer_id) REFERENCES customers (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE customer_addresses');
    }
}
