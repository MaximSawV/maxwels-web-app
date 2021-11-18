<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118110956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE done_requests (id INT AUTO_INCREMENT NOT NULL, vote VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE done_requests_requests (done_requests_id INT NOT NULL, requests_id INT NOT NULL, INDEX IDX_1AF4207A27005FA4 (done_requests_id), INDEX IDX_1AF4207A418F94FA (requests_id), PRIMARY KEY(done_requests_id, requests_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE done_requests_programmer (done_requests_id INT NOT NULL, programmer_id INT NOT NULL, INDEX IDX_6398079827005FA4 (done_requests_id), INDEX IDX_63980798181DAE45 (programmer_id), PRIMARY KEY(done_requests_id, programmer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programmer (id INT AUTO_INCREMENT NOT NULL, u_id_id INT NOT NULL, status VARCHAR(255) NOT NULL, done_requests INT DEFAULT NULL, positive_votes INT DEFAULT NULL, UNIQUE INDEX UNIQ_4136CCA96782F39A (u_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requests (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, creation_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_7B85D651B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE done_requests_requests ADD CONSTRAINT FK_1AF4207A27005FA4 FOREIGN KEY (done_requests_id) REFERENCES done_requests (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE done_requests_requests ADD CONSTRAINT FK_1AF4207A418F94FA FOREIGN KEY (requests_id) REFERENCES requests (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE done_requests_programmer ADD CONSTRAINT FK_6398079827005FA4 FOREIGN KEY (done_requests_id) REFERENCES done_requests (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE done_requests_programmer ADD CONSTRAINT FK_63980798181DAE45 FOREIGN KEY (programmer_id) REFERENCES programmer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmer ADD CONSTRAINT FK_4136CCA96782F39A FOREIGN KEY (u_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE requests ADD CONSTRAINT FK_7B85D651B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE done_requests_requests DROP FOREIGN KEY FK_1AF4207A27005FA4');
        $this->addSql('ALTER TABLE done_requests_programmer DROP FOREIGN KEY FK_6398079827005FA4');
        $this->addSql('ALTER TABLE done_requests_programmer DROP FOREIGN KEY FK_63980798181DAE45');
        $this->addSql('ALTER TABLE done_requests_requests DROP FOREIGN KEY FK_1AF4207A418F94FA');
        $this->addSql('DROP TABLE done_requests');
        $this->addSql('DROP TABLE done_requests_requests');
        $this->addSql('DROP TABLE done_requests_programmer');
        $this->addSql('DROP TABLE programmer');
        $this->addSql('DROP TABLE requests');
    }
}
