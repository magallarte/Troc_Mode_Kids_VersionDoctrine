<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412210712 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6638A536A8');
        // $this->addSql('ALTER TABLE delivery_bag DROP FOREIGN KEY FK_3C8D03E51F3E479F');
        // $this->addSql('ALTER TABLE donation_bag DROP FOREIGN KEY FK_89021E9A467628FF');
        $this->addSql('CREATE TABLE process_status (id INT AUTO_INCREMENT NOT NULL, process_status_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        // $this->addSql('DROP TABLE process_satus');
        // $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6638A536A8');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6638A536A8 FOREIGN KEY (article_process_status_id) REFERENCES process_status (id)');
        // $this->addSql('ALTER TABLE delivery_bag DROP FOREIGN KEY FK_3C8D03E51F3E479F');
        $this->addSql('ALTER TABLE delivery_bag ADD CONSTRAINT FK_3C8D03E51F3E479F FOREIGN KEY (delivery_bag_process_status_id) REFERENCES process_status (id)');
        // $this->addSql('ALTER TABLE donation_bag DROP FOREIGN KEY FK_89021E9A467628FF');
        $this->addSql('ALTER TABLE donation_bag ADD CONSTRAINT FK_89021E9A467628FF FOREIGN KEY (donation_bag_process_status_id) REFERENCES process_status (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6638A536A8');
        $this->addSql('ALTER TABLE delivery_bag DROP FOREIGN KEY FK_3C8D03E51F3E479F');
        $this->addSql('ALTER TABLE donation_bag DROP FOREIGN KEY FK_89021E9A467628FF');
        $this->addSql('CREATE TABLE process_satus (id INT AUTO_INCREMENT NOT NULL, process_status_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE process_status');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6638A536A8');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6638A536A8 FOREIGN KEY (article_process_status_id) REFERENCES process_satus (id)');
        $this->addSql('ALTER TABLE delivery_bag DROP FOREIGN KEY FK_3C8D03E51F3E479F');
        $this->addSql('ALTER TABLE delivery_bag ADD CONSTRAINT FK_3C8D03E51F3E479F FOREIGN KEY (delivery_bag_process_status_id) REFERENCES process_satus (id)');
        $this->addSql('ALTER TABLE donation_bag DROP FOREIGN KEY FK_89021E9A467628FF');
        $this->addSql('ALTER TABLE donation_bag ADD CONSTRAINT FK_89021E9A467628FF FOREIGN KEY (donation_bag_process_status_id) REFERENCES process_satus (id)');
    }
}
