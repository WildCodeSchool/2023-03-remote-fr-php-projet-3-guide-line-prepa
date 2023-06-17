<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617060347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sound (id INT AUTO_INCREMENT NOT NULL, instrument_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, player_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, INDEX IDX_F88EC384CF11D9C (instrument_id), INDEX IDX_F88EC384B7970CF8 (artist_id), INDEX IDX_F88EC38499E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC384CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC384B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC38499E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE instrument ADD category_id INT NOT NULL, ADD company_id INT NOT NULL, ADD release_at DATETIME DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD summary LONGTEXT DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD12469DE2 ON instrument (category_id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD979B1AD6 ON instrument (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD12469DE2');
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD979B1AD6');
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC384CF11D9C');
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC384B7970CF8');
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC38499E6F5DF');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE sound');
        $this->addSql('DROP INDEX IDX_3CBF69DD12469DE2 ON instrument');
        $this->addSql('DROP INDEX IDX_3CBF69DD979B1AD6 ON instrument');
        $this->addSql('ALTER TABLE instrument DROP category_id, DROP company_id, DROP release_at, DROP description, DROP summary, DROP slug');
    }
}
