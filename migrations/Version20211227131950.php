<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211227131950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_options (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, public_contact TINYINT(1) NOT NULL, show_status TINYINT(1) NOT NULL, hidden TINYINT(1) NOT NULL, darkmode TINYINT(1) NOT NULL, color1 VARCHAR(255) NOT NULL, color2 VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_38B241BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_options ADD CONSTRAINT FK_38B241BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_options');
    }
}
