<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116140420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE a (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voiture ADD marque_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F30964F9C FOREIGN KEY (marque_id_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810F30964F9C ON voiture (marque_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE a');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F30964F9C');
        $this->addSql('DROP INDEX IDX_E9E2810F30964F9C ON voiture');
        $this->addSql('ALTER TABLE voiture DROP marque_id_id');
    }
}
