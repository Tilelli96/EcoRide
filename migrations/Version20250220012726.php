<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220012726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE a (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, created_by_id INT DEFAULT NULL, commentaire VARCHAR(50) NOT NULL, note INT NOT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_E8B7BE439D86650F (user_id_id), INDEX IDX_E8B7BE43B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE covoiturage (id INT AUTO_INCREMENT NOT NULL, voiture_id_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_depart DATE NOT NULL, heure_depart TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', lieu_depart VARCHAR(50) NOT NULL, date_arrivee DATE NOT NULL, heure_arrivee TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', lieu_arrivee VARCHAR(50) NOT NULL, statut VARCHAR(50) NOT NULL, nb_place INT NOT NULL, prix_personne DOUBLE PRECISION NOT NULL, INDEX IDX_28C79E8952E93BA0 (voiture_id_id), INDEX IDX_28C79E89A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE covoiturage_voyageurs (covoiturage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_AE1C4B6B62671590 (covoiturage_id), INDEX IDX_AE1C4B6BA76ED395 (user_id), PRIMARY KEY(covoiturage_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE litige (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, covoiturage_id INT DEFAULT NULL, INDEX IDX_EEE9D46DA76ED395 (user_id), INDEX IDX_EEE9D46D62671590 (covoiturage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, libelle VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_57698A6A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, adresse_depart VARCHAR(50) NOT NULL, adresse_arrivee VARCHAR(50) NOT NULL, date DATE NOT NULL, nb_personnes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, adresse VARCHAR(50) NOT NULL, date_naissance DATETIME NOT NULL, photo LONGBLOB DEFAULT NULL, pseudo VARCHAR(50) NOT NULL, is_verified TINYINT(1) NOT NULL, note DOUBLE PRECISION NOT NULL, credit INT NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, marque_id_id INT NOT NULL, user_id_id INT DEFAULT NULL, modele VARCHAR(50) NOT NULL, immatriculation VARCHAR(50) NOT NULL, energie VARCHAR(50) NOT NULL, couleur VARCHAR(50) NOT NULL, date_premiere_immatriculation VARCHAR(50) NOT NULL, INDEX IDX_E9E2810F30964F9C (marque_id_id), INDEX IDX_E9E2810F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE a ADD CONSTRAINT FK_E8B7BE439D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE a ADD CONSTRAINT FK_E8B7BE43B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E8952E93BA0 FOREIGN KEY (voiture_id_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE covoiturage_voyageurs ADD CONSTRAINT FK_AE1C4B6B62671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('ALTER TABLE covoiturage_voyageurs ADD CONSTRAINT FK_AE1C4B6BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE litige ADD CONSTRAINT FK_EEE9D46DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE litige ADD CONSTRAINT FK_EEE9D46D62671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F30964F9C FOREIGN KEY (marque_id_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE a DROP FOREIGN KEY FK_E8B7BE439D86650F');
        $this->addSql('ALTER TABLE a DROP FOREIGN KEY FK_E8B7BE43B03A8386');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E8952E93BA0');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89A76ED395');
        $this->addSql('ALTER TABLE covoiturage_voyageurs DROP FOREIGN KEY FK_AE1C4B6B62671590');
        $this->addSql('ALTER TABLE covoiturage_voyageurs DROP FOREIGN KEY FK_AE1C4B6BA76ED395');
        $this->addSql('ALTER TABLE litige DROP FOREIGN KEY FK_EEE9D46DA76ED395');
        $this->addSql('ALTER TABLE litige DROP FOREIGN KEY FK_EEE9D46D62671590');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A9D86650F');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F30964F9C');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F9D86650F');
        $this->addSql('DROP TABLE a');
        $this->addSql('DROP TABLE covoiturage');
        $this->addSql('DROP TABLE covoiturage_voyageurs');
        $this->addSql('DROP TABLE litige');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
