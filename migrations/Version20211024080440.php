<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211024080440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill ADD liked SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE parent_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_skill DROP liked, CHANGE user_id_id user_id_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP liked');
        $this->addSql('ALTER TABLE `user` CHANGE parent_id parent_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_skill ADD liked VARBINARY(255) NOT NULL, CHANGE user_id_id user_id_id INT NOT NULL');
    }
}
