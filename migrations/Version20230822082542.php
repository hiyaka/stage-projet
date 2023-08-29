<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822082542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salles ADD batiments_id INT NOT NULL');
        $this->addSql('ALTER TABLE salles ADD CONSTRAINT FK_799D45AA6DC28240 FOREIGN KEY (batiments_id) REFERENCES batiments (id)');
        $this->addSql('CREATE INDEX IDX_799D45AA6DC28240 ON salles (batiments_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salles DROP FOREIGN KEY FK_799D45AA6DC28240');
        $this->addSql('DROP INDEX IDX_799D45AA6DC28240 ON salles');
        $this->addSql('ALTER TABLE salles DROP batiments_id');
    }
}
