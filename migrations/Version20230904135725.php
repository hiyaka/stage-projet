<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230904135725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes ADD statut_id INT NOT NULL');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBBF6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_BD940CBBF6203804 ON demandes (statut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBBF6203804');
        $this->addSql('DROP INDEX IDX_BD940CBBF6203804 ON demandes');
        $this->addSql('ALTER TABLE demandes DROP statut_id');
    }
}
