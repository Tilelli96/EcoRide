<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116143355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE a ADD user_id_id INT NOT NULL, ADD commentaire VARCHAR(50) NOT NULL, ADD note INT NOT NULL, ADD statut VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE a ADD CONSTRAINT FK_E8B7BE439D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E8B7BE439D86650F ON a (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE a DROP FOREIGN KEY FK_E8B7BE439D86650F');
        $this->addSql('DROP INDEX IDX_E8B7BE439D86650F ON a');
        $this->addSql('ALTER TABLE a DROP user_id_id, DROP commentaire, DROP note, DROP statut');
    }
}
