<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180416143127 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, delivery_school_stop_id INT DEFAULT NULL, delivery_type VARCHAR(255) NOT NULL, INDEX IDX_3781EC10B20249A (delivery_school_stop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, news_editor_id INT DEFAULT NULL, news_title VARCHAR(255) NOT NULL, news_source VARCHAR(255) DEFAULT NULL, news_url VARCHAR(255) DEFAULT NULL, news_picture VARCHAR(255) DEFAULT NULL, news_content LONGTEXT DEFAULT NULL, news_edit_date DATE DEFAULT NULL, INDEX IDX_1DD3995075B0F38D (news_editor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_stop (id INT AUTO_INCREMENT NOT NULL, school_stop_school_id INT NOT NULL, school_stop_date DATETIME NOT NULL, INDEX IDX_F87EC95B356DD943 (school_stop_school_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10B20249A FOREIGN KEY (delivery_school_stop_id) REFERENCES school_stop (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995075B0F38D FOREIGN KEY (news_editor_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE school_stop ADD CONSTRAINT FK_F87EC95B356DD943 FOREIGN KEY (school_stop_school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE delivery_bag ADD delivery_bag_delivery_id INT DEFAULT NULL, ADD delivery_bag_delivery_fee DOUBLE PRECISION DEFAULT NULL, ADD delivery_bag_delivery_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery_bag ADD CONSTRAINT FK_3C8D03E5DE847851 FOREIGN KEY (delivery_bag_delivery_id) REFERENCES delivery (id)');
        $this->addSql('CREATE INDEX IDX_3C8D03E5DE847851 ON delivery_bag (delivery_bag_delivery_id)');
        $this->addSql('ALTER TABLE donation_bag ADD donation_bag_school_stop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE donation_bag ADD CONSTRAINT FK_89021E9A2AA5F21E FOREIGN KEY (donation_bag_school_stop_id) REFERENCES school_stop (id)');
        $this->addSql('CREATE INDEX IDX_89021E9A2AA5F21E ON donation_bag (donation_bag_school_stop_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery_bag DROP FOREIGN KEY FK_3C8D03E5DE847851');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10B20249A');
        $this->addSql('ALTER TABLE donation_bag DROP FOREIGN KEY FK_89021E9A2AA5F21E');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE school_stop');
        $this->addSql('DROP INDEX IDX_3C8D03E5DE847851 ON delivery_bag');
        $this->addSql('ALTER TABLE delivery_bag DROP delivery_bag_delivery_id, DROP delivery_bag_delivery_fee, DROP delivery_bag_delivery_date');
        $this->addSql('DROP INDEX IDX_89021E9A2AA5F21E ON donation_bag');
        $this->addSql('ALTER TABLE donation_bag DROP donation_bag_school_stop_id');
    }
}
