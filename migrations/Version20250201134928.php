<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201134928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, adresse_depart VARCHAR(50) NOT NULL, adresse_arrivee VARCHAR(50) NOT NULL, date DATE NOT NULL, nb_personnes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE covoiturage CHANGE prix_personne prix_personne DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE search');
        $this->addSql('ALTER TABLE covoiturage CHANGE prix_personne prix_personne VARCHAR(255) NOT NULL');
    }
}
