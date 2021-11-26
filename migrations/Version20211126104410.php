<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211126104410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriber ADD created_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriber ADD CONSTRAINT FK_AD005B69DE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_AD005B69DE12AB56 ON subscriber (created_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriber DROP FOREIGN KEY FK_AD005B69DE12AB56');
        $this->addSql('DROP INDEX IDX_AD005B69DE12AB56 ON subscriber');
        $this->addSql('ALTER TABLE subscriber DROP created_by');
    }
}
