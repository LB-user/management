<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019140628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_skill (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, skill_id_id INT NOT NULL, liked VARBINARY(255) NOT NULL, INDEX IDX_BCFF1F2F9D86650F (user_id_id), INDEX IDX_BCFF1F2F5A6C0D6B (skill_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F5A6C0D6B FOREIGN KEY (skill_id_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE user CHANGE parent_id parent_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_skill DROP FOREIGN KEY FK_BCFF1F2F5A6C0D6B');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE user_skill');
        $this->addSql('ALTER TABLE `user` CHANGE parent_id parent_id INT DEFAULT NULL');
    }
}
