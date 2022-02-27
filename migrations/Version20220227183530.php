<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227183530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, option_type_id INT NOT NULL, option_name VARCHAR(255) NOT NULL, INDEX IDX_5A8600B0DDB89BE6 (option_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_type (id INT AUTO_INCREMENT NOT NULL, option_type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, product_type_id INT NOT NULL, product_name VARCHAR(255) NOT NULL, product_price INT NOT NULL, INDEX IDX_D34A04AD14959723 (product_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_option (product_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_38FA41144584665A (product_id), INDEX IDX_38FA4114A7C41D6F (option_id), PRIMARY KEY(product_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_tag (product_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E3A6E39C4584665A (product_id), INDEX IDX_E3A6E39CBAD26311 (tag_id), PRIMARY KEY(product_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, product_type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, tag_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B0DDB89BE6 FOREIGN KEY (option_type_id) REFERENCES option_type (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD14959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id)');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA41144584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114A7C41D6F');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B0DDB89BE6');
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA41144584665A');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39C4584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD14959723');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39CBAD26311');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_type');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_option');
        $this->addSql('DROP TABLE product_tag');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP TABLE tag');
    }
}
