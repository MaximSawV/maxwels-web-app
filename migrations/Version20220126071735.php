<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126071735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship ADD user_id INT NOT NULL, ADD reference_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2A01E763D FOREIGN KEY (reference_user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_A0C838A2A76ED395 ON user_relationship (user_id)');
        $this->addSql('CREATE INDEX IDX_A0C838A2A01E763D ON user_relationship (reference_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2A76ED395');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2A01E763D');
        $this->addSql('DROP INDEX IDX_A0C838A2A76ED395 ON user_relationship');
        $this->addSql('DROP INDEX IDX_A0C838A2A01E763D ON user_relationship');
        $this->addSql('ALTER TABLE user_relationship DROP user_id, DROP reference_user_id');
    }
}
