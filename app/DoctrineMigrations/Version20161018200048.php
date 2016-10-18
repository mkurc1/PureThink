<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161018200048 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cms_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, context INT DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_6CA2D53C727ACA70 (parent_id), INDEX IDX_6CA2D53CE25D857E (context), INDEX IDX_6CA2D53CEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_collection (id INT AUTO_INCREMENT NOT NULL, context INT DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_CF8D1EB7E25D857E (context), INDEX IDX_CF8D1EB7EA9FDD75 (media_id), UNIQUE INDEX tag_collection (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cms_context (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cms_category ADD CONSTRAINT FK_6CA2D53C727ACA70 FOREIGN KEY (parent_id) REFERENCES cms_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_category ADD CONSTRAINT FK_6CA2D53CE25D857E FOREIGN KEY (context) REFERENCES cms_context (id)');
        $this->addSql('ALTER TABLE cms_category ADD CONSTRAINT FK_6CA2D53CEA9FDD75 FOREIGN KEY (media_id) REFERENCES cms_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cms_collection ADD CONSTRAINT FK_CF8D1EB7E25D857E FOREIGN KEY (context) REFERENCES cms_context (id)');
        $this->addSql('ALTER TABLE cms_collection ADD CONSTRAINT FK_CF8D1EB7EA9FDD75 FOREIGN KEY (media_id) REFERENCES cms_media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cms_media ADD category_id INT DEFAULT NULL, ADD cdn_flush_identifier VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_media ADD CONSTRAINT FK_445F3A2012469DE2 FOREIGN KEY (category_id) REFERENCES cms_category (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_445F3A2012469DE2 ON cms_media (category_id)');
        $this->addSql('DROP INDEX UNIQ_428C7EF85E237E06 ON cms_tag');
        $this->addSql('ALTER TABLE cms_tag ADD context INT DEFAULT NULL, ADD enabled TINYINT(1) NOT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cms_tag ADD CONSTRAINT FK_428C7EF8E25D857E FOREIGN KEY (context) REFERENCES cms_context (id)');
        $this->addSql('CREATE INDEX IDX_428C7EF8E25D857E ON cms_tag (context)');
        $this->addSql('CREATE UNIQUE INDEX tag_context ON cms_tag (slug, context)');
        $this->addSql('ALTER TABLE cms_user CHANGE biography biography VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_article ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD6017712469DE2 FOREIGN KEY (category_id) REFERENCES cms_category (id)');
        $this->addSql('CREATE INDEX IDX_5CD6017712469DE2 ON cms_article (category_id)');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69593CB796C');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69593CB796C FOREIGN KEY (file_id) REFERENCES cms_media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_AB0CF69570AAEA5 ON cms_component_has_value (dtype)');
        $this->addSql('ALTER TABLE cms_language ADD media_id INT DEFAULT NULL, ADD position INT NOT NULL');
        $this->addSql('ALTER TABLE cms_language ADD CONSTRAINT FK_BE35BD48EA9FDD75 FOREIGN KEY (media_id) REFERENCES cms_media (id)');
        $this->addSql('CREATE INDEX IDX_BE35BD48EA9FDD75 ON cms_language (media_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_category DROP FOREIGN KEY FK_6CA2D53C727ACA70');
        $this->addSql('ALTER TABLE cms_media DROP FOREIGN KEY FK_445F3A2012469DE2');
        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD6017712469DE2');
        $this->addSql('ALTER TABLE cms_category DROP FOREIGN KEY FK_6CA2D53CE25D857E');
        $this->addSql('ALTER TABLE cms_collection DROP FOREIGN KEY FK_CF8D1EB7E25D857E');
        $this->addSql('ALTER TABLE cms_tag DROP FOREIGN KEY FK_428C7EF8E25D857E');
        $this->addSql('DROP TABLE cms_category');
        $this->addSql('DROP TABLE cms_collection');
        $this->addSql('DROP TABLE cms_context');
        $this->addSql('DROP INDEX IDX_5CD6017712469DE2 ON cms_article');
        $this->addSql('ALTER TABLE cms_article DROP category_id');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69593CB796C');
        $this->addSql('DROP INDEX IDX_AB0CF69570AAEA5 ON cms_component_has_value');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69593CB796C FOREIGN KEY (file_id) REFERENCES cms_media (id)');
        $this->addSql('ALTER TABLE cms_language DROP FOREIGN KEY FK_BE35BD48EA9FDD75');
        $this->addSql('DROP INDEX IDX_BE35BD48EA9FDD75 ON cms_language');
        $this->addSql('ALTER TABLE cms_language DROP media_id, DROP position');
        $this->addSql('DROP INDEX IDX_445F3A2012469DE2 ON cms_media');
        $this->addSql('ALTER TABLE cms_media DROP category_id, DROP cdn_flush_identifier');
        $this->addSql('DROP INDEX IDX_428C7EF8E25D857E ON cms_tag');
        $this->addSql('DROP INDEX tag_context ON cms_tag');
        $this->addSql('ALTER TABLE cms_tag DROP context, DROP enabled, DROP slug');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_428C7EF85E237E06 ON cms_tag (name)');
        $this->addSql('ALTER TABLE cms_user CHANGE biography biography VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
