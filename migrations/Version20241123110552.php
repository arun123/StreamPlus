<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123110552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE address1 address1 LONGTEXT DEFAULT NULL, CHANGE address2 address2 VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE postal_code postal_code VARCHAR(255) DEFAULT NULL, CHANGE state state VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL, CHANGE cc_number cc_number VARCHAR(255) DEFAULT NULL, CHANGE cvv cvv VARCHAR(255) DEFAULT NULL, CHANGE expiration_date expiration_date VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE address1 address1 LONGTEXT NOT NULL, CHANGE address2 address2 VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(255) NOT NULL, CHANGE postal_code postal_code VARCHAR(255) NOT NULL, CHANGE state state VARCHAR(255) NOT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE cc_number cc_number VARCHAR(255) NOT NULL, CHANGE cvv cvv VARCHAR(255) NOT NULL, CHANGE expiration_date expiration_date VARCHAR(255) NOT NULL');
    }
}
