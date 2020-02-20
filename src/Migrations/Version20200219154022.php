<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219154022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD cmpt_d_id INT NOT NULL, ADD cmpt_c_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D123D5A735 FOREIGN KEY (cmpt_d_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BE029F8C FOREIGN KEY (cmpt_c_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D123D5A735 ON transaction (cmpt_d_id)');
        $this->addSql('CREATE INDEX IDX_723705D1BE029F8C ON transaction (cmpt_c_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D123D5A735');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BE029F8C');
        $this->addSql('DROP INDEX IDX_723705D123D5A735 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1BE029F8C ON transaction');
        $this->addSql('ALTER TABLE transaction DROP cmpt_d_id, DROP cmpt_c_id');
    }
}
