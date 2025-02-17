<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217181252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage ADD user_id_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E899D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_28C79E899D86650F ON covoiturage (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E899D86650F');
        $this->addSql('DROP INDEX IDX_28C79E899D86650F ON covoiturage');
        $this->addSql('ALTER TABLE covoiturage ADD user_id INT NOT NULL, DROP user_id_id');
    }
}
