<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260130141023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about (id INT AUTO_INCREMENT NOT NULL, hero_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, profile_image VARCHAR(255) DEFAULT NULL, headline VARCHAR(255) DEFAULT NULL, short_description LONGTEXT DEFAULT NULL, birthday VARCHAR(100) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, age VARCHAR(10) DEFAULT NULL, degree VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, freelance_status VARCHAR(50) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_B5F422E345B0BCD (hero_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hero (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hero_job (id INT AUTO_INCREMENT NOT NULL, hero_id INT NOT NULL, title VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75DD6D6D45B0BCD (hero_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE register (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE about ADD CONSTRAINT FK_B5F422E345B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id)');
        $this->addSql('ALTER TABLE hero_job ADD CONSTRAINT FK_75DD6D6D45B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E345B0BCD');
        $this->addSql('ALTER TABLE hero_job DROP FOREIGN KEY FK_75DD6D6D45B0BCD');
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE hero');
        $this->addSql('DROP TABLE hero_job');
        $this->addSql('DROP TABLE register');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
