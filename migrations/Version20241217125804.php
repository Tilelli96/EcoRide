<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217125804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage CHANGE date_depart date_depart DATE NOT NULL, CHANGE heure_depart heure_depart TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', CHANGE date_arrivee date_arrivee DATE NOT NULL, CHANGE heure_arrivee heure_arrivee TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', CHANGE prix_personne prix_personne VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage CHANGE date_depart date_depart DATETIME NOT NULL, CHANGE heure_depart heure_depart DATETIME NOT NULL, CHANGE date_arrivee date_arrivee DATETIME NOT NULL, CHANGE heure_arrivee heure_arrivee VARCHAR(50) NOT NULL, CHANGE prix_personne prix_personne DOUBLE PRECISION NOT NULL');
    }
}
