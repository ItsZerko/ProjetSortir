<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213090736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, id_sortie_id INT NOT NULL, date_inscription DATETIME NOT NULL, id_participant VARCHAR(255) NOT NULL, INDEX IDX_5E90F6D64C476574 (id_sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, roles TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, password_verif VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D79F6B115126AC48 (mail), INDEX IDX_D79F6B11F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, sortie_id INT DEFAULT NULL, lieu_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_heure_debut DATETIME NOT NULL, duree INT NOT NULL, date_limite_inscription DATETIME NOT NULL, nb_inscription_max INT NOT NULL, info_sortie LONGTEXT NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_3C3FD3F2CC72D953 (sortie_id), INDEX IDX_3C3FD3F26AB213CC (lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, nom VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, INDEX IDX_2F577D59A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D64C476574 FOREIGN KEY (id_sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2CC72D953 FOREIGN KEY (sortie_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F26AB213CC FOREIGN KEY (lieu_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_2F577D59A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE participant_sortie');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_2F577D59A73F0036');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11F6BD1646');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2CC72D953');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D64C476574');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F26AB213CC');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant_sortie (participant_id INT NOT NULL, sortie_id INT NOT NULL, INDEX IDX_8E436D73CC72D953 (sortie_id), INDEX IDX_8E436D739D1C3019 (participant_id), PRIMARY KEY(participant_id, sortie_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE ville');
    }
}
