<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223131418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogpost ADD onglet_id INT NOT NULL');
        $this->addSql('ALTER TABLE blogpost ADD CONSTRAINT FK_1284FB7DBD1A86CC FOREIGN KEY (onglet_id) REFERENCES onglet (id)');
        $this->addSql('CREATE INDEX IDX_1284FB7DBD1A86CC ON blogpost (onglet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blogpost DROP FOREIGN KEY FK_1284FB7DBD1A86CC');
        $this->addSql('DROP INDEX IDX_1284FB7DBD1A86CC ON blogpost');
        $this->addSql('ALTER TABLE blogpost DROP onglet_id');
    }
}
