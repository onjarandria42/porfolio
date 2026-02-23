<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration: Create new entities for portfolio management
 */
final class Version20250220000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Skill, Service, Stat, ResumeItem, PortfolioCategory, PortfolioItem, Testimonial, ContactInfo, SiteSettings, ContactMessage entities';
    }

    public function up(Schema $schema): void
    {
        // Skill table
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, percentage INT NOT NULL, icon VARCHAR(50) DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Service table
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(50) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Stat table
        $this->addSql('CREATE TABLE stat (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, subtitle VARCHAR(100) DEFAULT NULL, value INT NOT NULL, icon VARCHAR(50) DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // ResumeItem table
        $this->addSql('CREATE TABLE resume_item (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(100) DEFAULT NULL, period VARCHAR(100) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, details JSON DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // PortfolioCategory table
        $this->addSql('CREATE TABLE portfolio_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(50) DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // PortfolioItem table
        $this->addSql('CREATE TABLE portfolio_item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, detail_link VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6B0AC8B212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Testimonial table
        $this->addSql('CREATE TABLE testimonial (id INT AUTO_INCREMENT NOT NULL, author_name VARCHAR(150) NOT NULL, author_role VARCHAR(150) DEFAULT NULL, author_image VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // ContactInfo table
        $this->addSql('CREATE TABLE contact_info (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, map_embed_url LONGTEXT DEFAULT NULL, linkedin VARCHAR(100) DEFAULT NULL, github VARCHAR(100) DEFAULT NULL, twitter VARCHAR(100) DEFAULT NULL, facebook VARCHAR(100) DEFAULT NULL, instagram VARCHAR(100) DEFAULT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // SiteSettings table
        $this->addSql('CREATE TABLE site_settings (id INT AUTO_INCREMENT NOT NULL, site_name VARCHAR(255) DEFAULT NULL, site_title VARCHAR(255) DEFAULT NULL, site_description LONGTEXT DEFAULT NULL, site_logo VARCHAR(255) DEFAULT NULL, favicon VARCHAR(255) DEFAULT NULL, meta_author VARCHAR(100) DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, cv_file VARCHAR(255) DEFAULT NULL, maintenance_mode TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // ContactMessage table
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, email VARCHAR(150) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, status VARCHAR(50) DEFAULT \'new\' NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', read_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Foreign key constraints
        $this->addSql('ALTER TABLE portfolio_item ADD CONSTRAINT FK_6B0AC8B212469DE2 FOREIGN KEY (category_id) REFERENCES portfolio_category (id)');
    }

    public function down(Schema $schema): void
    {
        // Drop tables in reverse order
        $this->addSql('ALTER TABLE portfolio_item DROP FOREIGN KEY FK_6B0AC8B212469DE2');
        
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE site_settings');
        $this->addSql('DROP TABLE contact_info');
        $this->addSql('DROP TABLE testimonial');
        $this->addSql('DROP TABLE portfolio_item');
        $this->addSql('DROP TABLE portfolio_category');
        $this->addSql('DROP TABLE resume_item');
        $this->addSql('DROP TABLE stat');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE skill');
    }
}
