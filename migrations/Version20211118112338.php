<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118112338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, done_by_id INT DEFAULT NULL, creation_date DATE NOT NULL, status VARCHAR(255) NOT NULL, context LONGTEXT NOT NULL, rating VARCHAR(255) DEFAULT NULL, done_on DATE DEFAULT NULL, INDEX IDX_3B978F9FB03A8386 (created_by_id), INDEX IDX_3B978F9F35AE3EF9 (done_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FB03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F35AE3EF9 FOREIGN KEY (done_by_id) REFERENCES programmer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE request');
    }
}
