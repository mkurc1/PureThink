<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160519180013 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cms_article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, view_id INT NOT NULL, published TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5CD60177A76ED395 (user_id), UNIQUE INDEX UNIQ_5CD6017731518C7 (view_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_article_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, excerpt LONGTEXT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, keyword VARCHAR(255) DEFAULT NULL, locale VARCHAR(10) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BDE10D46989D9B62 (slug), INDEX IDX_BDE10D462C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_BDE10D462C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_article_view (id INT AUTO_INCREMENT NOT NULL, views INT NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_component (id INT AUTO_INCREMENT NOT NULL, extension_id INT NOT NULL, slug VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8A98C13A989D9B62 (slug), INDEX IDX_8A98C13A812D5EB (extension_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_component_has_value (id INT AUTO_INCREMENT NOT NULL, component_has_element_id INT DEFAULT NULL, extension_has_field_id INT DEFAULT NULL, article_id INT DEFAULT NULL, file_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, dtype VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_AB0CF695AE16CB1E (component_has_element_id), INDEX IDX_AB0CF69541B6A7F (extension_has_field_id), INDEX IDX_AB0CF6957294869C (article_id), INDEX IDX_AB0CF69593CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_component_has_element (id INT AUTO_INCREMENT NOT NULL, component_id INT NOT NULL, enabled TINYINT(1) DEFAULT NULL, position INT NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C732EB05E2ABAFFF (component_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_component_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, locale VARCHAR(10) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_55EA98882C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_55EA98882C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_extension (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_extension_has_field (id INT AUTO_INCREMENT NOT NULL, extension_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, label_of_field VARCHAR(255) NOT NULL, required TINYINT(1) DEFAULT NULL, is_main_field TINYINT(1) DEFAULT NULL, position INT NOT NULL, type_of_field INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_70B3B6BA812D5EB (extension_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_gallery_has_media (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7D63D1A74E7AF8F (gallery_id), INDEX IDX_7D63D1A7EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_user_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_BCC2C4185E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, alias VARCHAR(3) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable TINYINT(1) DEFAULT NULL, cdn_flush_at DATETIME DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_menu (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, type_id INT NOT NULL, article_id INT DEFAULT NULL, position INT DEFAULT NULL, published TINYINT(1) DEFAULT NULL, is_new_page TINYINT(1) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, dtype VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_BA9397EECCD7E912 (menu_id), INDEX IDX_BA9397EEC54C8C93 (type_id), INDEX IDX_BA9397EE7294869C (article_id), INDEX IDX_BA9397EE70AAEA5 (dtype), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_menu_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, locale VARCHAR(10) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4C8ABA592C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_4C8ABA592C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_menu_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_87F7C70A989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_site (id INT AUTO_INCREMENT NOT NULL, tracking_code LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_site_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, keyword VARCHAR(255) DEFAULT NULL, locale VARCHAR(10) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CF589BA52C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_CF589BA52C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, date_of_birth DATETIME DEFAULT NULL, firstname VARCHAR(64) DEFAULT NULL, lastname VARCHAR(64) DEFAULT NULL, website VARCHAR(64) DEFAULT NULL, biography VARCHAR(255) DEFAULT NULL, gender VARCHAR(1) DEFAULT NULL, locale VARCHAR(8) DEFAULT NULL, timezone VARCHAR(64) DEFAULT NULL, phone VARCHAR(64) DEFAULT NULL, facebook_uid VARCHAR(255) DEFAULT NULL, facebook_name VARCHAR(255) DEFAULT NULL, facebook_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', twitter_uid VARCHAR(255) DEFAULT NULL, twitter_name VARCHAR(255) DEFAULT NULL, twitter_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', gplus_uid VARCHAR(255) DEFAULT NULL, gplus_name VARCHAR(255) DEFAULT NULL, gplus_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', token VARCHAR(255) DEFAULT NULL, two_step_code VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4A057B3492FC23A8 (username_canonical), UNIQUE INDEX UNIQ_4A057B34A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_user_user_group (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_8899927EA76ED395 (user_id), INDEX IDX_8899927EFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD60177A76ED395 FOREIGN KEY (user_id) REFERENCES cms_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD6017731518C7 FOREIGN KEY (view_id) REFERENCES cms_article_view (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_article_translation ADD CONSTRAINT FK_BDE10D462C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cms_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component ADD CONSTRAINT FK_8A98C13A812D5EB FOREIGN KEY (extension_id) REFERENCES cms_extension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF695AE16CB1E FOREIGN KEY (component_has_element_id) REFERENCES cms_component_has_element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69541B6A7F FOREIGN KEY (extension_has_field_id) REFERENCES cms_extension_has_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF6957294869C FOREIGN KEY (article_id) REFERENCES cms_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69593CB796C FOREIGN KEY (file_id) REFERENCES cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_has_element ADD CONSTRAINT FK_C732EB05E2ABAFFF FOREIGN KEY (component_id) REFERENCES cms_component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_translation ADD CONSTRAINT FK_55EA98882C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cms_component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_extension_has_field ADD CONSTRAINT FK_70B3B6BA812D5EB FOREIGN KEY (extension_id) REFERENCES cms_extension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_gallery_has_media ADD CONSTRAINT FK_7D63D1A74E7AF8F FOREIGN KEY (gallery_id) REFERENCES cms_gallery (id)');
        $this->addSql('ALTER TABLE cms_gallery_has_media ADD CONSTRAINT FK_7D63D1A7EA9FDD75 FOREIGN KEY (media_id) REFERENCES cms_media (id)');
        $this->addSql('ALTER TABLE cms_menu ADD CONSTRAINT FK_BA9397EECCD7E912 FOREIGN KEY (menu_id) REFERENCES cms_menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_menu ADD CONSTRAINT FK_BA9397EEC54C8C93 FOREIGN KEY (type_id) REFERENCES cms_menu_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_menu ADD CONSTRAINT FK_BA9397EE7294869C FOREIGN KEY (article_id) REFERENCES cms_article (id)');
        $this->addSql('ALTER TABLE cms_menu_translation ADD CONSTRAINT FK_4C8ABA592C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cms_menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_site_translation ADD CONSTRAINT FK_CF589BA52C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cms_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_user_user_group ADD CONSTRAINT FK_8899927EA76ED395 FOREIGN KEY (user_id) REFERENCES cms_user (id)');
        $this->addSql('ALTER TABLE cms_user_user_group ADD CONSTRAINT FK_8899927EFE54D947 FOREIGN KEY (group_id) REFERENCES cms_user_group (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_article_translation DROP FOREIGN KEY FK_BDE10D462C2AC5D3');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF6957294869C');
        $this->addSql('ALTER TABLE cms_menu DROP FOREIGN KEY FK_BA9397EE7294869C');
        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD6017731518C7');
        $this->addSql('ALTER TABLE cms_component_has_element DROP FOREIGN KEY FK_C732EB05E2ABAFFF');
        $this->addSql('ALTER TABLE cms_component_translation DROP FOREIGN KEY FK_55EA98882C2AC5D3');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF695AE16CB1E');
        $this->addSql('ALTER TABLE cms_component DROP FOREIGN KEY FK_8A98C13A812D5EB');
        $this->addSql('ALTER TABLE cms_extension_has_field DROP FOREIGN KEY FK_70B3B6BA812D5EB');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69541B6A7F');
        $this->addSql('ALTER TABLE cms_gallery_has_media DROP FOREIGN KEY FK_7D63D1A74E7AF8F');
        $this->addSql('ALTER TABLE cms_user_user_group DROP FOREIGN KEY FK_8899927EFE54D947');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69593CB796C');
        $this->addSql('ALTER TABLE cms_gallery_has_media DROP FOREIGN KEY FK_7D63D1A7EA9FDD75');
        $this->addSql('ALTER TABLE cms_menu DROP FOREIGN KEY FK_BA9397EECCD7E912');
        $this->addSql('ALTER TABLE cms_menu_translation DROP FOREIGN KEY FK_4C8ABA592C2AC5D3');
        $this->addSql('ALTER TABLE cms_menu DROP FOREIGN KEY FK_BA9397EEC54C8C93');
        $this->addSql('ALTER TABLE cms_site_translation DROP FOREIGN KEY FK_CF589BA52C2AC5D3');
        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD60177A76ED395');
        $this->addSql('ALTER TABLE cms_user_user_group DROP FOREIGN KEY FK_8899927EA76ED395');
        $this->addSql('DROP TABLE cms_article');
        $this->addSql('DROP TABLE cms_article_translation');
        $this->addSql('DROP TABLE cms_article_view');
        $this->addSql('DROP TABLE cms_component');
        $this->addSql('DROP TABLE cms_component_has_value');
        $this->addSql('DROP TABLE cms_component_has_element');
        $this->addSql('DROP TABLE cms_component_translation');
        $this->addSql('DROP TABLE cms_extension');
        $this->addSql('DROP TABLE cms_extension_has_field');
        $this->addSql('DROP TABLE cms_gallery');
        $this->addSql('DROP TABLE cms_gallery_has_media');
        $this->addSql('DROP TABLE cms_user_group');
        $this->addSql('DROP TABLE cms_language');
        $this->addSql('DROP TABLE cms_media');
        $this->addSql('DROP TABLE cms_menu');
        $this->addSql('DROP TABLE cms_menu_translation');
        $this->addSql('DROP TABLE cms_menu_type');
        $this->addSql('DROP TABLE cms_site');
        $this->addSql('DROP TABLE cms_site_translation');
        $this->addSql('DROP TABLE cms_user');
        $this->addSql('DROP TABLE cms_user_user_group');
    }
}
