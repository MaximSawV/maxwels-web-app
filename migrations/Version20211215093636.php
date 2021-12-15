<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215093636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programmer ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE programmer ADD CONSTRAINT FK_4136CCA9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4136CCA9A76ED395 ON programmer (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programmer DROP FOREIGN KEY FK_4136CCA9A76ED395');
        $this->addSql('DROP INDEX UNIQ_4136CCA9A76ED395 ON programmer');
        $this->addSql('ALTER TABLE programmer DROP user_id');
    }
}
