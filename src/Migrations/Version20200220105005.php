<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220105005 extends AbstractMigration
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
        $this->addSql('ALTER TABLE sortie ADD motif_annulation LONGTEXT DEFAULT NULL, CHANGE sortie_id sortie_id INT DEFAULT NULL, CHANGE sites_id sites_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participant CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie DROP motif_annulation, CHANGE sortie_id sortie_id INT DEFAULT NULL, CHANGE sites_id sites_id INT DEFAULT NULL');
    }
}
