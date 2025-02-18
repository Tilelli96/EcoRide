<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218092134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage_voyageurs DROP FOREIGN KEY FK_AE1C4B6BA76ED395');
        $this->addSql('DROP INDEX idx_ae1c4b6ba76ed395 ON covoiturage_voyageurs');
        $this->addSql('CREATE INDEX IDX_AE1C4B6B68D3EA09 ON covoiturage_voyageurs (User_id)');
        $this->addSql('ALTER TABLE covoiturage_voyageurs ADD CONSTRAINT FK_AE1C4B6BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage_voyageurs DROP FOREIGN KEY FK_AE1C4B6B68D3EA09');
        $this->addSql('DROP INDEX idx_ae1c4b6b68d3ea09 ON covoiturage_voyageurs');
        $this->addSql('CREATE INDEX IDX_AE1C4B6BA76ED395 ON covoiturage_voyageurs (user_id)');
        $this->addSql('ALTER TABLE covoiturage_voyageurs ADD CONSTRAINT FK_AE1C4B6B68D3EA09 FOREIGN KEY (User_id) REFERENCES user (id)');
    }
}
