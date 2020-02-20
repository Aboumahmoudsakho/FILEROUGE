<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219142454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affectation ADD useraffecter_id INT NOT NULL');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3767379E1 FOREIGN KEY (useraffecter_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F4DD61D3767379E1 ON affectation (useraffecter_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3767379E1');
        $this->addSql('DROP INDEX IDX_F4DD61D3767379E1 ON affectation');
        $this->addSql('ALTER TABLE affectation DROP useraffecter_id');
    }
}
