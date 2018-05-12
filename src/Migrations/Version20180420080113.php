<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180420080113 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A25214E1');
        $this->addSql('DROP INDEX IDX_23A0E66A25214E1 ON article');
        $this->addSql('ALTER TABLE article CHANGE article_delivey_bag_id article_delivery_bag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6692894B87 FOREIGN KEY (article_delivery_bag_id) REFERENCES delivery_bag (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6692894B87 ON article (article_delivery_bag_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6692894B87');
        $this->addSql('DROP INDEX IDX_23A0E6692894B87 ON article');
        $this->addSql('ALTER TABLE article CHANGE article_delivery_bag_id article_delivey_bag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A25214E1 FOREIGN KEY (article_delivey_bag_id) REFERENCES delivery_bag (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A25214E1 ON article (article_delivey_bag_id)');
    }
}
