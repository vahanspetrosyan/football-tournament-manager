<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828181525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fmatch (id INT AUTO_INCREMENT NOT NULL, team1_id INT NOT NULL, team2_id INT NOT NULL, tournament_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_D3167FFCE72BCFA4 (team1_id), INDEX IDX_D3167FFCF59E604A (team2_id), INDEX IDX_D3167FFC33D1A3E7 (tournament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BD5FB8D9989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fmatch ADD CONSTRAINT FK_D3167FFCE72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE fmatch ADD CONSTRAINT FK_D3167FFCF59E604A FOREIGN KEY (team2_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE fmatch ADD CONSTRAINT FK_D3167FFC33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fmatch DROP FOREIGN KEY FK_D3167FFCE72BCFA4');
        $this->addSql('ALTER TABLE fmatch DROP FOREIGN KEY FK_D3167FFCF59E604A');
        $this->addSql('ALTER TABLE fmatch DROP FOREIGN KEY FK_D3167FFC33D1A3E7');
        $this->addSql('DROP TABLE fmatch');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE tournament');
    }
}
