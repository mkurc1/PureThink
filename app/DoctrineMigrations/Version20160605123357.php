<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160605123357 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cms_article_has_tag (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_7A6745C17294869C (article_id), INDEX IDX_7A6745C1BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, response TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_428C7EF85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cms_article_has_tag ADD CONSTRAINT FK_7A6745C17294869C FOREIGN KEY (article_id) REFERENCES cms_article (id)');
        $this->addSql('ALTER TABLE cms_article_has_tag ADD CONSTRAINT FK_7A6745C1BAD26311 FOREIGN KEY (tag_id) REFERENCES cms_tag (id)');
        $this->addSql('ALTER TABLE cms_article ADD gallery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD601774E7AF8F FOREIGN KEY (gallery_id) REFERENCES cms_gallery (id)');
        $this->addSql('CREATE INDEX IDX_5CD601774E7AF8F ON cms_article (gallery_id)');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69541B6A7F');
        $this->addSql('ALTER TABLE cms_component_has_value ADD boolean TINYINT(1) DEFAULT NULL, ADD date DATETIME DEFAULT NULL, CHANGE extension_has_field_id extension_has_field_id INT NOT NULL');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69541B6A7F FOREIGN KEY (extension_has_field_id) REFERENCES cms_extension_has_field (id)');
        $this->addSql('ALTER TABLE cms_menu DROP FOREIGN KEY FK_BA9397EEC54C8C93');
        $this->addSql('ALTER TABLE cms_menu ADD action VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_menu ADD CONSTRAINT FK_BA9397EEC54C8C93 FOREIGN KEY (type_id) REFERENCES cms_menu_type (id)');
        $this->addSql('ALTER TABLE cms_site ADD contact_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_site_translation CHANGE description description VARCHAR(2000) DEFAULT NULL, CHANGE keyword keyword VARCHAR(2000) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_article_has_tag DROP FOREIGN KEY FK_7A6745C1BAD26311');
        $this->addSql('DROP TABLE cms_article_has_tag');
        $this->addSql('DROP TABLE cms_contact');
        $this->addSql('DROP TABLE cms_tag');
        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD601774E7AF8F');
        $this->addSql('DROP INDEX IDX_5CD601774E7AF8F ON cms_article');
        $this->addSql('ALTER TABLE cms_article DROP gallery_id');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69541B6A7F');
        $this->addSql('ALTER TABLE cms_component_has_value DROP boolean, DROP date, CHANGE extension_has_field_id extension_has_field_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69541B6A7F FOREIGN KEY (extension_has_field_id) REFERENCES cms_extension_has_field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_menu DROP FOREIGN KEY FK_BA9397EEC54C8C93');
        $this->addSql('ALTER TABLE cms_menu DROP action');
        $this->addSql('ALTER TABLE cms_menu ADD CONSTRAINT FK_BA9397EEC54C8C93 FOREIGN KEY (type_id) REFERENCES cms_menu_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_site DROP contact_email');
        $this->addSql('ALTER TABLE cms_site_translation CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE keyword keyword VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
