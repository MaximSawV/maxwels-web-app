<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107111711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, last_message_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_659DF2AABA0E79C3 (last_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, source_id INT NOT NULL, in_chat_id INT NOT NULL, content LONGTEXT NOT NULL, created_on DATETIME NOT NULL, INDEX IDX_FAB3FC16953C1C61 (source_id), INDEX IDX_FAB3FC16512952CB (in_chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_participant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, read_last_message TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E8ED9C89A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_participant_chat (chat_participant_id INT NOT NULL, chat_id INT NOT NULL, INDEX IDX_444534598BEABE04 (chat_participant_id), INDEX IDX_444534591A9A7125 (chat_id), PRIMARY KEY(chat_participant_id, chat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AABA0E79C3 FOREIGN KEY (last_message_id) REFERENCES chat_message (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16953C1C61 FOREIGN KEY (source_id) REFERENCES chat_participant (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16512952CB FOREIGN KEY (in_chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE chat_participant ADD CONSTRAINT FK_E8ED9C89A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE chat_participant_chat ADD CONSTRAINT FK_444534598BEABE04 FOREIGN KEY (chat_participant_id) REFERENCES chat_participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat_participant_chat ADD CONSTRAINT FK_444534591A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16512952CB');
        $this->addSql('ALTER TABLE chat_participant_chat DROP FOREIGN KEY FK_444534591A9A7125');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AABA0E79C3');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16953C1C61');
        $this->addSql('ALTER TABLE chat_participant_chat DROP FOREIGN KEY FK_444534598BEABE04');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE chat_participant');
        $this->addSql('DROP TABLE chat_participant_chat');
    }
}
