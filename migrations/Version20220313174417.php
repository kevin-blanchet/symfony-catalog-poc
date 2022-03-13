<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220313174417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_type_option_type (product_type_id INT NOT NULL, option_type_id INT NOT NULL, INDEX IDX_A1454EA714959723 (product_type_id), INDEX IDX_A1454EA7DDB89BE6 (option_type_id), PRIMARY KEY(product_type_id, option_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_type_option_type ADD CONSTRAINT FK_A1454EA714959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type_option_type ADD CONSTRAINT FK_A1454EA7DDB89BE6 FOREIGN KEY (option_type_id) REFERENCES option_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_type_option_type');
    }
}
