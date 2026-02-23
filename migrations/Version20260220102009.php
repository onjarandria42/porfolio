<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260220102009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_info CHANGE map_embed_url map_embed_url VARCHAR(255) DEFAULT NULL, CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE contact_message CHANGE status status VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE hero ADD profile_image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE portfolio_category CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE portfolio_item CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE portfolio_item RENAME INDEX idx_6b0ac8b212469de2 TO IDX_2F2A62E412469DE2');
        $this->addSql('ALTER TABLE resume_item CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE service CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE site_settings CHANGE maintenance_mode maintenance_mode TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE skill CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stat CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE testimonial CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E016BA31DB ON messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test');
        $this->addSql('ALTER TABLE contact_info CHANGE map_embed_url map_embed_url LONGTEXT DEFAULT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE contact_message CHANGE status status VARCHAR(50) DEFAULT \'new\' NOT NULL');
        $this->addSql('ALTER TABLE hero DROP profile_image');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('ALTER TABLE portfolio_category CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE portfolio_item CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE portfolio_item RENAME INDEX idx_2f2a62e412469de2 TO IDX_6B0AC8B212469DE2');
        $this->addSql('ALTER TABLE resume_item CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE service CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE site_settings CHANGE maintenance_mode maintenance_mode TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE skill CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE stat CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE testimonial CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
    }
}
