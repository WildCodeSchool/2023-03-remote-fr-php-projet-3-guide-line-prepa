<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627122939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_sound (user_id INT NOT NULL, sound_id INT NOT NULL, INDEX IDX_1A4C38DCA76ED395 (user_id), INDEX IDX_1A4C38DC6AAA5C3E (sound_id), PRIMARY KEY(user_id, sound_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_sound ADD CONSTRAINT FK_1A4C38DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sound ADD CONSTRAINT FK_1A4C38DC6AAA5C3E FOREIGN KEY (sound_id) REFERENCES sound (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_sound DROP FOREIGN KEY FK_1A4C38DCA76ED395');
        $this->addSql('ALTER TABLE user_sound DROP FOREIGN KEY FK_1A4C38DC6AAA5C3E');
        $this->addSql('DROP TABLE user_sound');
    }
}
