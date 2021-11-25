<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125114242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscriber (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY request_ibfk_1');
        $this->addSql('ALTER TABLE request CHANGE status status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F93863CAE FOREIGN KEY (working_on) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subscriber');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F93863CAE');
        $this->addSql('ALTER TABLE request CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'REQUESTED\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT request_ibfk_1 FOREIGN KEY (working_on) REFERENCES programmer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
