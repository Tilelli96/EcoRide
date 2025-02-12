<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210193133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE a CHANGE commentaire commentaire VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE a ADD CONSTRAINT FK_E8B7BE439D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE a ADD CONSTRAINT FK_E8B7BE43B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE a DROP FOREIGN KEY FK_E8B7BE439D86650F');
        $this->addSql('ALTER TABLE a DROP FOREIGN KEY FK_E8B7BE43B03A8386');
        $this->addSql('ALTER TABLE a CHANGE commentaire commentaire LONGTEXT NOT NULL');
    }
}
