<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217202801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE litige ADD user_id INT DEFAULT NULL, ADD covoiturage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE litige ADD CONSTRAINT FK_EEE9D46DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE litige ADD CONSTRAINT FK_EEE9D46D62671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('CREATE INDEX IDX_EEE9D46DA76ED395 ON litige (user_id)');
        $this->addSql('CREATE INDEX IDX_EEE9D46D62671590 ON litige (covoiturage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE litige DROP FOREIGN KEY FK_EEE9D46DA76ED395');
        $this->addSql('ALTER TABLE litige DROP FOREIGN KEY FK_EEE9D46D62671590');
        $this->addSql('DROP INDEX IDX_EEE9D46DA76ED395 ON litige');
        $this->addSql('DROP INDEX IDX_EEE9D46D62671590 ON litige');
        $this->addSql('ALTER TABLE litige DROP user_id, DROP covoiturage_id');
    }
}
