<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160620225900 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cms_component_has_value_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, locale VARCHAR(10) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_313530D2C2AC5D3 (translatable_id), UNIQUE INDEX UNIQ_313530D2C2AC5D34180C698 (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cms_component_has_value_translation ADD CONSTRAINT FK_313530D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cms_component_has_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_article ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD60177EA9FDD75 FOREIGN KEY (media_id) REFERENCES cms_media (id)');
        $this->addSql('CREATE INDEX IDX_5CD60177EA9FDD75 ON cms_article (media_id)');
        $this->addSql('ALTER TABLE cms_component ADD media_id INT DEFAULT NULL, CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE cms_component ADD CONSTRAINT FK_8A98C13AEA9FDD75 FOREIGN KEY (media_id) REFERENCES cms_media (id)');
        $this->addSql('CREATE INDEX IDX_8A98C13AEA9FDD75 ON cms_component (media_id)');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69593CB796C');
        $this->addSql('ALTER TABLE cms_component_has_value DROP text');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69593CB796C FOREIGN KEY (file_id) REFERENCES cms_media (id)');
        $this->addSql('ALTER TABLE cms_component_has_element CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE cms_component_translation ADD description VARCHAR(2000) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_menu ADD section VARCHAR(255) DEFAULT NULL, CHANGE published published TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE cms_site ADD add_title_to_sub_pages TINYINT(1) DEFAULT \'1\' NOT NULL, ADD send_contact_request_on_email TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cms_component_has_value_translation');
        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD60177EA9FDD75');
        $this->addSql('DROP INDEX IDX_5CD60177EA9FDD75 ON cms_article');
        $this->addSql('ALTER TABLE cms_article DROP media_id');
        $this->addSql('ALTER TABLE cms_component DROP FOREIGN KEY FK_8A98C13AEA9FDD75');
        $this->addSql('DROP INDEX IDX_8A98C13AEA9FDD75 ON cms_component');
        $this->addSql('ALTER TABLE cms_component DROP media_id, CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_component_has_element CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_component_has_value DROP FOREIGN KEY FK_AB0CF69593CB796C');
        $this->addSql('ALTER TABLE cms_component_has_value ADD text LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE cms_component_has_value ADD CONSTRAINT FK_AB0CF69593CB796C FOREIGN KEY (file_id) REFERENCES cms_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cms_component_translation DROP description');
        $this->addSql('ALTER TABLE cms_menu DROP section, CHANGE published published TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_site DROP add_title_to_sub_pages, DROP send_contact_request_on_email');
    }
}
