<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211202111314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, deadline DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_programmer (project_id INT NOT NULL, programmer_id INT NOT NULL, INDEX IDX_5990B79B166D1F9C (project_id), INDEX IDX_5990B79B181DAE45 (programmer_id), PRIMARY KEY(project_id, programmer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_programmer ADD CONSTRAINT FK_5990B79B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_programmer ADD CONSTRAINT FK_5990B79B181DAE45 FOREIGN KEY (programmer_id) REFERENCES programmer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request ADD part_of_project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FF04091D FOREIGN KEY (part_of_project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_3B978F9FF04091D ON request (part_of_project_id)');
        $this->addSql('ALTER TABLE subscriber DROP FOREIGN KEY subscriber_ibfk_1');
        $this->addSql('DROP INDEX email ON subscriber');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE project_programmer DROP FOREIGN KEY FK_5990B79B166D1F9C');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FF04091D');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE project_programmer');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX IDX_3B978F9FF04091D ON request');
        $this->addSql('ALTER TABLE request DROP part_of_project_id');
        $this->addSql('ALTER TABLE subscriber ADD CONSTRAINT subscriber_ibfk_1 FOREIGN KEY (email) REFERENCES user (email) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX email ON subscriber (email)');
    }
}
