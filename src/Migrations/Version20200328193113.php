<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200328193113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_accounts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE transactions (id INT NOT NULL, debit_account_id INT NOT NULL, credit_account_id INT NOT NULL, date DATE NOT NULL, amount BIGINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAA81A4C204C4EAA ON transactions (debit_account_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C6813E404 ON transactions (credit_account_id)');
        $this->addSql('CREATE TABLE user_accounts (id INT NOT NULL, sum INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, account_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E99B6B5FBA ON users (account_id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C204C4EAA FOREIGN KEY (debit_account_id) REFERENCES user_accounts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C6813E404 FOREIGN KEY (credit_account_id) REFERENCES user_accounts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99B6B5FBA FOREIGN KEY (account_id) REFERENCES user_accounts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C204C4EAA');
        $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C6813E404');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E99B6B5FBA');
        $this->addSql('DROP SEQUENCE transactions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_accounts_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE user_accounts');
        $this->addSql('DROP TABLE users');
    }
}
