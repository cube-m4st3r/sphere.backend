<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329125033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE CGOrder (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, reward INT NOT NULL, Customer_id INT NOT NULL, INDEX IDX_818C1CF15094C24 (Customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CGOrderItem (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cgorderitem_cgorder (cgorderitem_id INT NOT NULL, cgorder_id INT NOT NULL, INDEX IDX_9242DF3E1816C54 (cgorderitem_id), INDEX IDX_9242DF3E9E58939 (cgorder_id), PRIMARY KEY(cgorderitem_id, cgorder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cgorderitem_item (cgorderitem_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_ECA5872A1816C54 (cgorderitem_id), INDEX IDX_ECA5872A126F525E (item_id), PRIMARY KEY(cgorderitem_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Customer (id INT AUTO_INCREMENT NOT NULL, PlayableCharacter_id INT NOT NULL, DiscordInfo_id INT NOT NULL, UNIQUE INDEX UNIQ_784FEC5FE6821235 (PlayableCharacter_id), UNIQUE INDEX UNIQ_784FEC5F3F684F53 (DiscordInfo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE CGOrder ADD CONSTRAINT FK_818C1CF15094C24 FOREIGN KEY (Customer_id) REFERENCES Customer (id)');
        $this->addSql('ALTER TABLE cgorderitem_cgorder ADD CONSTRAINT FK_9242DF3E1816C54 FOREIGN KEY (cgorderitem_id) REFERENCES CGOrderItem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cgorderitem_cgorder ADD CONSTRAINT FK_9242DF3E9E58939 FOREIGN KEY (cgorder_id) REFERENCES CGOrder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cgorderitem_item ADD CONSTRAINT FK_ECA5872A1816C54 FOREIGN KEY (cgorderitem_id) REFERENCES CGOrderItem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cgorderitem_item ADD CONSTRAINT FK_ECA5872A126F525E FOREIGN KEY (item_id) REFERENCES Item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5FE6821235 FOREIGN KEY (PlayableCharacter_id) REFERENCES PlayableCharacter (id)');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F3F684F53 FOREIGN KEY (DiscordInfo_id) REFERENCES DiscordUser (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE CGOrder DROP FOREIGN KEY FK_818C1CF15094C24');
        $this->addSql('ALTER TABLE cgorderitem_cgorder DROP FOREIGN KEY FK_9242DF3E1816C54');
        $this->addSql('ALTER TABLE cgorderitem_cgorder DROP FOREIGN KEY FK_9242DF3E9E58939');
        $this->addSql('ALTER TABLE cgorderitem_item DROP FOREIGN KEY FK_ECA5872A1816C54');
        $this->addSql('ALTER TABLE cgorderitem_item DROP FOREIGN KEY FK_ECA5872A126F525E');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5FE6821235');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F3F684F53');
        $this->addSql('DROP TABLE CGOrder');
        $this->addSql('DROP TABLE CGOrderItem');
        $this->addSql('DROP TABLE cgorderitem_cgorder');
        $this->addSql('DROP TABLE cgorderitem_item');
        $this->addSql('DROP TABLE Customer');
    }
}
