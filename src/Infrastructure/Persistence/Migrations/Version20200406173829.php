<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406173829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE registered_clients_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE registered_clients (id INT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, uuid UUID NOT NULL, is_granted BOOLEAN DEFAULT NULL, is_revoked BOOLEAN DEFAULT NULL, grant_date DATE DEFAULT NULL, revoke_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_107D320D17F50A6 ON registered_clients (uuid)');
        $this->addSql('CREATE INDEX IDX_107D32019EB6921 ON registered_clients (client_id)');
        $this->addSql('CREATE INDEX IDX_107D320A76ED395 ON registered_clients (user_id)');
        $this->addSql('COMMENT ON COLUMN registered_clients.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE registered_clients ADD CONSTRAINT FK_107D32019EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registered_clients ADD CONSTRAINT FK_107D320A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE registered_clients_id_seq CASCADE');
        $this->addSql('DROP TABLE registered_clients');
    }
}
