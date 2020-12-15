<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215135626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, brewery_id INT DEFAULT NULL, cat_id INT DEFAULT NULL, style_id INT DEFAULT NULL, abv DOUBLE PRECISION DEFAULT NULL, ibu INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, add_user INT DEFAULT NULL, last_mod DATETIME DEFAULT NULL, style VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, brewer VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, coordinates VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beer');
    }
}
