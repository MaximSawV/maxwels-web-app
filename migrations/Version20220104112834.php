<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104112834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_A0C838A2C7096C ON user_relationship (referingUser)');
        $this->addSql('CREATE INDEX IDX_A0C838A2A7483798 ON user_relationship (referencedUser)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request DROP INDEX UNIQ_3B978F9FDE12AB56, ADD INDEX IDX_3B978F9FDE12AB56 (created_by)');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FDE12AB56');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F93863CAE');
        $this->addSql('ALTER TABLE request CHANGE created_by created_by INT NOT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT request_ibfk_1 FOREIGN KEY (created_by) REFERENCES customer (user_id_id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT request_ibfk_2 FOREIGN KEY (working_on) REFERENCES programmer (user_id) ON UPDATE NO ACTION ON DELETE CASCADE');
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
