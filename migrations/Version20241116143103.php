<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116143103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage ADD voiture_id_id INT DEFAULT NULL, ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E8952E93BA0 FOREIGN KEY (voiture_id_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E899D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_28C79E8952E93BA0 ON covoiturage (voiture_id_id)');
        $this->addSql('CREATE INDEX IDX_28C79E899D86650F ON covoiturage (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E8952E93BA0');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E899D86650F');
        $this->addSql('DROP INDEX IDX_28C79E8952E93BA0 ON covoiturage');
        $this->addSql('DROP INDEX IDX_28C79E899D86650F ON covoiturage');
        $this->addSql('ALTER TABLE covoiturage DROP voiture_id_id, DROP user_id_id');
    }
}
