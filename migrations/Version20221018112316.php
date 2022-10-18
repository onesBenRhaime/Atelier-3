<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018112316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE label label VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC09A1CAE');
        $this->addSql('DROP INDEX IDX_D34A04ADC09A1CAE ON product');
        $this->addSql('ALTER TABLE product CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE id_cat_id category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD9777D11E ON product (category_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE label label VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9777D11E');
        $this->addSql('DROP INDEX IDX_D34A04AD9777D11E ON product');
        $this->addSql('ALTER TABLE product CHANGE price price VARCHAR(255) NOT NULL, CHANGE category_id_id id_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC09A1CAE FOREIGN KEY (id_cat_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADC09A1CAE ON product (id_cat_id)');
    }
}
