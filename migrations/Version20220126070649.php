<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126070649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2A7483798');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2C7096C');
        $this->addSql('DROP INDEX IDX_A0C838A2A7483798 ON user_relationship');
        $this->addSql('DROP INDEX IDX_A0C838A2C7096C ON user_relationship');
        $this->addSql('ALTER TABLE user_relationship DROP refering_user_id, DROP referenced_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_relationship ADD refering_user_id INT NOT NULL, ADD referenced_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2A7483798 FOREIGN KEY (referenced_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2C7096C FOREIGN KEY (refering_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A0C838A2A7483798 ON user_relationship (referenced_user_id)');
        $this->addSql('CREATE INDEX IDX_A0C838A2C7096C ON user_relationship (refering_user_id)');
    }
}
