<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219130000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, envoyeur_id INT NOT NULL, donneur_id INT DEFAULT NULL, nomcomp_e VARCHAR(255) NOT NULL, telephone_e VARCHAR(255) NOT NULL, nin VARCHAR(255) NOT NULL, envoyer_at DATETIME NOT NULL, nomcomp_b VARCHAR(255) NOT NULL, telephone_b VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, frais VARCHAR(255) NOT NULL, comission_etat DOUBLE PRECISION NOT NULL, comission_envoi DOUBLE PRECISION NOT NULL, comission_system DOUBLE PRECISION NOT NULL, code_envoi VARCHAR(255) NOT NULL, ninb VARCHAR(255) DEFAULT NULL, retrait_at DATETIME DEFAULT NULL, comissionretrait DOUBLE PRECISION DEFAULT NULL, INDEX IDX_723705D14795A786 (envoyeur_id), INDEX IDX_723705D19789825B (donneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14795A786 FOREIGN KEY (envoyeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D19789825B FOREIGN KEY (donneur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE transaction');
    }
}
