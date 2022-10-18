<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018102340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD id_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC09A1CAE FOREIGN KEY (id_cat_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADC09A1CAE ON product (id_cat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC09A1CAE');
        $this->addSql('DROP INDEX IDX_D34A04ADC09A1CAE ON product');
        $this->addSql('ALTER TABLE product DROP id_cat_id');
    }
}
