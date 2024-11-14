<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114111242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE covoiturage (id INT AUTO_INCREMENT NOT NULL, date_depart DATETIME NOT NULL, heure_depart DATETIME NOT NULL, lieu_depart VARCHAR(50) NOT NULL, date_arrivee DATETIME NOT NULL, heure_arrivee VARCHAR(50) NOT NULL, lieu_arrivee VARCHAR(50) NOT NULL, statut VARCHAR(50) NOT NULL, nb_place INT NOT NULL, prix_personne DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE covoiturage');
    }
}
