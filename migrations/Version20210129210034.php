<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129210034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, libele VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, date_acquisation DATE NOT NULL, prix NUMERIC(10, 2) NOT NULL, quantite NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE site ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E453C59D72 FOREIGN KEY (responsable_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_694309E453C59D72 ON site (responsable_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE materiel');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E453C59D72');
        $this->addSql('DROP INDEX UNIQ_694309E453C59D72 ON site');
        $this->addSql('ALTER TABLE site DROP responsable_id');
    }
}
