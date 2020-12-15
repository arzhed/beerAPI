<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215184846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer ADD brewery_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD style_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADD15C960 FOREIGN KEY (brewery_id) REFERENCES brewery (id)');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADBACD6074 FOREIGN KEY (style_id) REFERENCES style (id)');
        $this->addSql('CREATE INDEX IDX_58F666ADD15C960 ON beer (brewery_id)');
        $this->addSql('CREATE INDEX IDX_58F666AD12469DE2 ON beer (category_id)');
        $this->addSql('CREATE INDEX IDX_58F666ADBACD6074 ON beer (style_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADD15C960');
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666AD12469DE2');
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADBACD6074');
        $this->addSql('DROP INDEX IDX_58F666ADD15C960 ON beer');
        $this->addSql('DROP INDEX IDX_58F666AD12469DE2 ON beer');
        $this->addSql('DROP INDEX IDX_58F666ADBACD6074 ON beer');
        $this->addSql('ALTER TABLE beer DROP brewery_id, DROP category_id, DROP style_id');
    }
}
