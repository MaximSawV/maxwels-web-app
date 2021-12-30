<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230135112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F93863CAE');
        $this->addSql('DROP INDEX IDX_3B978F9F93863CAE ON request');
        $this->addSql('ALTER TABLE request CHANGE working_on working_on VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE request RENAME INDEX created_by TO IDX_3B978F9FDE12AB56');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request CHANGE working_on working_on INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F93863CAE FOREIGN KEY (working_on) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3B978F9F93863CAE ON request (working_on)');
        $this->addSql('ALTER TABLE request RENAME INDEX idx_3b978f9fde12ab56 TO created_by');
    }
}
