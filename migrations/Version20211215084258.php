<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215084258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E099D86650F');
        $this->addSql('DROP INDEX UNIQ_81398E099D86650F ON customer');
        $this->addSql('ALTER TABLE customer CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E099D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E099D86650F ON customer (user_id_id)');
        $this->addSql('ALTER TABLE request DROP INDEX IDX_3B978F9FDE12AB56, ADD UNIQUE INDEX UNIQ_3B978F9FDE12AB56 (created_by)');
        $this->addSql('ALTER TABLE subscriber DROP FOREIGN KEY subscriber_ibfk_1');
        $this->addSql('DROP INDEX email ON subscriber');
        $this->addSql('ALTER TABLE user ADD customer_or_programmer VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E099D86650F');
        $this->addSql('DROP INDEX UNIQ_81398E099D86650F ON customer');
        $this->addSql('ALTER TABLE customer CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E099D86650F FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E099D86650F ON customer (user_id)');
        $this->addSql('ALTER TABLE request DROP INDEX UNIQ_3B978F9FDE12AB56, ADD INDEX IDX_3B978F9FDE12AB56 (created_by)');
        $this->addSql('ALTER TABLE subscriber ADD CONSTRAINT subscriber_ibfk_1 FOREIGN KEY (email) REFERENCES user (email) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX email ON subscriber (email)');
        $this->addSql('ALTER TABLE `user` DROP customer_or_programmer');
    }
}
