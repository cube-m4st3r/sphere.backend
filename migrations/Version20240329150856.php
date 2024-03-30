<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329150856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cgorderitem_item DROP FOREIGN KEY FK_ECA5872A126F525E');
        $this->addSql('ALTER TABLE cgorderitem_item DROP FOREIGN KEY FK_ECA5872A1816C54');
        $this->addSql('ALTER TABLE cgorderitem_cgorder DROP FOREIGN KEY FK_9242DF3E1816C54');
        $this->addSql('ALTER TABLE cgorderitem_cgorder DROP FOREIGN KEY FK_9242DF3E9E58939');
        $this->addSql('DROP TABLE cgorderitem_item');
        $this->addSql('DROP TABLE cgorderitem_cgorder');
        $this->addSql('ALTER TABLE CGOrderItem ADD CGOrder_id INT DEFAULT NULL, ADD Item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE CGOrderItem ADD CONSTRAINT FK_8DAA986C3D3F6A1C FOREIGN KEY (CGOrder_id) REFERENCES CGOrder (id)');
        $this->addSql('ALTER TABLE CGOrderItem ADD CONSTRAINT FK_8DAA986CDDD26BC2 FOREIGN KEY (Item_id) REFERENCES Item (id)');
        $this->addSql('CREATE INDEX IDX_8DAA986C3D3F6A1C ON CGOrderItem (CGOrder_id)');
        $this->addSql('CREATE INDEX IDX_8DAA986CDDD26BC2 ON CGOrderItem (Item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cgorderitem_item (cgorderitem_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_ECA5872A1816C54 (cgorderitem_id), INDEX IDX_ECA5872A126F525E (item_id), PRIMARY KEY(cgorderitem_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cgorderitem_cgorder (cgorderitem_id INT NOT NULL, cgorder_id INT NOT NULL, INDEX IDX_9242DF3E1816C54 (cgorderitem_id), INDEX IDX_9242DF3E9E58939 (cgorder_id), PRIMARY KEY(cgorderitem_id, cgorder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cgorderitem_item ADD CONSTRAINT FK_ECA5872A126F525E FOREIGN KEY (item_id) REFERENCES Item (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cgorderitem_item ADD CONSTRAINT FK_ECA5872A1816C54 FOREIGN KEY (cgorderitem_id) REFERENCES CGOrderItem (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cgorderitem_cgorder ADD CONSTRAINT FK_9242DF3E1816C54 FOREIGN KEY (cgorderitem_id) REFERENCES CGOrderItem (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cgorderitem_cgorder ADD CONSTRAINT FK_9242DF3E9E58939 FOREIGN KEY (cgorder_id) REFERENCES CGOrder (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE CGOrderItem DROP FOREIGN KEY FK_8DAA986C3D3F6A1C');
        $this->addSql('ALTER TABLE CGOrderItem DROP FOREIGN KEY FK_8DAA986CDDD26BC2');
        $this->addSql('DROP INDEX IDX_8DAA986C3D3F6A1C ON CGOrderItem');
        $this->addSql('DROP INDEX IDX_8DAA986CDDD26BC2 ON CGOrderItem');
        $this->addSql('ALTER TABLE CGOrderItem DROP CGOrder_id, DROP Item_id');
    }
}
