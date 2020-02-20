<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212123915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, proprietaire_id INT NOT NULL, numc VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, soldes DOUBLE PRECISION NOT NULL, INDEX IDX_CFF6526073A201E5 (createur_id), INDEX IDX_CFF6526076C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, depositeur_id INT NOT NULL, ccrediteur_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, deposer_at DATETIME NOT NULL, INDEX IDX_47948BBC8091D587 (depositeur_id), INDEX IDX_47948BBC9530708F (ccrediteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, ninea VARCHAR(255) NOT NULL, nrc VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, logo LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526073A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526076C50E4A FOREIGN KEY (proprietaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC8091D587 FOREIGN KEY (depositeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC9530708F FOREIGN KEY (ccrediteur_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE user ADD partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64998DE13AC ON user (partenaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC9530708F');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526076C50E4A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998DE13AC');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP INDEX IDX_8D93D64998DE13AC ON user');
        $this->addSql('ALTER TABLE user DROP partenaire_id');
    }
}
