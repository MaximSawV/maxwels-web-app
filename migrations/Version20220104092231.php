<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104092231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP status');
        $this->addSql('ALTER TABLE programmer DROP FOREIGN KEY programmer_ibfk_1');
        $this->addSql('ALTER TABLE programmer ADD CONSTRAINT FK_4136CCA9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FDE12AB56 FOREIGN KEY (created_by) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F93863CAE FOREIGN KEY (working_on) REFERENCES programmer (id)');
        $this->addSql('ALTER TABLE request RENAME INDEX working_on TO IDX_3B978F9F93863CAE');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY referencedUser_userId');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY referingUser_userId');
        $this->addSql('DROP INDEX referencedUser_userId ON user_relationship');
        $this->addSql('DROP INDEX referingUser_userId ON user_relationship');
        $this->addSql('ALTER TABLE user_relationship ADD refering_user_id id, ADD referenced_user_id id, ADD is_friend TINYINT(1) NOT NULL, ADD is_blocked TINYINT(1) NOT NULL, DROP referingUser, DROP referencedUser, DROP isFriend, DROP isBlocked, CHANGE priority priority INT NOT NULL');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2C7096C FOREIGN KEY (refering_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2A7483798 FOREIGN KEY (referenced_user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_A0C838A2C7096C ON user_relationship (refering_user_id)');
        $this->addSql('CREATE INDEX IDX_A0C838A2A7483798 ON user_relationship (referenced_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE programmer DROP FOREIGN KEY FK_4136CCA9A76ED395');
        $this->addSql('ALTER TABLE programmer ADD CONSTRAINT programmer_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request DROP INDEX UNIQ_3B978F9FDE12AB56, ADD INDEX IDX_3B978F9FDE12AB56 (created_by)');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FDE12AB56');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F93863CAE');
        $this->addSql('ALTER TABLE request CHANGE created_by created_by INT NOT NULL');
        $this->addSql('ALTER TABLE request RENAME INDEX idx_3b978f9f93863cae TO working_on');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2C7096C');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2A7483798');
        $this->addSql('DROP INDEX IDX_A0C838A2C7096C ON user_relationship');
        $this->addSql('DROP INDEX IDX_A0C838A2A7483798 ON user_relationship');
        $this->addSql('ALTER TABLE user_relationship ADD referingUser INT NOT NULL, ADD referencedUser INT NOT NULL, ADD isFriend TINYINT(1) DEFAULT \'0\' NOT NULL, ADD isBlocked TINYINT(1) DEFAULT \'0\' NOT NULL, DROP refering_user_id, DROP referenced_user_id, DROP is_friend, DROP is_blocked, CHANGE priority priority INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT referencedUser_userId FOREIGN KEY (referencedUser) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT referingUser_userId FOREIGN KEY (referingUser) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX referencedUser_userId ON user_relationship (referencedUser)');
        $this->addSql('CREATE INDEX referingUser_userId ON user_relationship (referingUser)');
    }
}
