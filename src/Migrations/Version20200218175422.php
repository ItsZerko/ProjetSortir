<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218175422 extends AbstractMigration
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
        $this->addSql('ALTER TABLE sortie ADD sites_id INT DEFAULT NULL, CHANGE sortie_id sortie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F27838E496 FOREIGN KEY (sites_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F27838E496 ON sortie (sites_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participant CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F27838E496');
        $this->addSql('DROP INDEX IDX_3C3FD3F27838E496 ON sortie');
        $this->addSql('ALTER TABLE sortie DROP sites_id, CHANGE sortie_id sortie_id INT DEFAULT NULL');
    }
}
