<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220091120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participant CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie CHANGE sortie_id sortie_id INT DEFAULT NULL, CHANGE sites_id sites_id INT DEFAULT NULL, CHANGE motif_annulation motif_annulation LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participant CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie CHANGE sortie_id sortie_id INT DEFAULT NULL, CHANGE sites_id sites_id INT DEFAULT NULL, CHANGE motif_annulation motif_annulation LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
