<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412165701 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, article_brand_id INT NOT NULL, article_type_id INT NOT NULL, article_size_id INT NOT NULL, article_wear_status_id INT NOT NULL, article_gender_id INT NOT NULL, article_process_status_id INT NOT NULL, article_delivey_bag_id INT DEFAULT NULL, article_donation_bag_id INT DEFAULT NULL, article_picture1 VARCHAR(255) NOT NULL, article_picture2 VARCHAR(255) DEFAULT NULL, article_picture3 VARCHAR(255) DEFAULT NULL, article_button_value DOUBLE PRECISION NOT NULL, article_euros_value DOUBLE PRECISION NOT NULL, article_comments LONGTEXT DEFAULT NULL, INDEX IDX_23A0E66111D2463 (article_brand_id), INDEX IDX_23A0E66289EC824 (article_type_id), INDEX IDX_23A0E66A45FEC90 (article_size_id), INDEX IDX_23A0E663BA68704 (article_wear_status_id), INDEX IDX_23A0E66DD3DF0C4 (article_gender_id), INDEX IDX_23A0E6638A536A8 (article_process_status_id), INDEX IDX_23A0E66A25214E1 (article_delivey_bag_id), INDEX IDX_23A0E664F4F96F2 (article_donation_bag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_color (article_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_11E13AF87294869C (article_id), INDEX IDX_11E13AF87ADA1FB5 (color_id), PRIMARY KEY(article_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_fabric (article_id INT NOT NULL, fabric_id INT NOT NULL, INDEX IDX_724E7237294869C (article_id), INDEX IDX_724E723AB43EC50 (fabric_id), PRIMARY KEY(article_id, fabric_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_bag (id INT AUTO_INCREMENT NOT NULL, delivery_bag_buyer_id INT NOT NULL, delivery_bag_process_status_id INT NOT NULL, delivery_bag_service_fee DOUBLE PRECISION NOT NULL, delivery_bag_button_amount DOUBLE PRECISION DEFAULT NULL, delivery_bag_buy_date DATE NOT NULL, INDEX IDX_3C8D03E526E29DE1 (delivery_bag_buyer_id), INDEX IDX_3C8D03E51F3E479F (delivery_bag_process_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation_bag (id INT AUTO_INCREMENT NOT NULL, donation_bag_donator_id INT NOT NULL, donation_bag_process_status_id INT NOT NULL, donation_bag_date DATE NOT NULL, INDEX IDX_89021E9A800DF22B (donation_bag_donator_id), INDEX IDX_89021E9A467628FF (donation_bag_process_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66111D2463 FOREIGN KEY (article_brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66289EC824 FOREIGN KEY (article_type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A45FEC90 FOREIGN KEY (article_size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663BA68704 FOREIGN KEY (article_wear_status_id) REFERENCES wear_status (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DD3DF0C4 FOREIGN KEY (article_gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6638A536A8 FOREIGN KEY (article_process_status_id) REFERENCES process_satus (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A25214E1 FOREIGN KEY (article_delivey_bag_id) REFERENCES delivery_bag (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664F4F96F2 FOREIGN KEY (article_donation_bag_id) REFERENCES donation_bag (id)');
        $this->addSql('ALTER TABLE article_color ADD CONSTRAINT FK_11E13AF87294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_color ADD CONSTRAINT FK_11E13AF87ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_fabric ADD CONSTRAINT FK_724E7237294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_fabric ADD CONSTRAINT FK_724E723AB43EC50 FOREIGN KEY (fabric_id) REFERENCES fabric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE delivery_bag ADD CONSTRAINT FK_3C8D03E526E29DE1 FOREIGN KEY (delivery_bag_buyer_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE delivery_bag ADD CONSTRAINT FK_3C8D03E51F3E479F FOREIGN KEY (delivery_bag_process_status_id) REFERENCES process_satus (id)');
        $this->addSql('ALTER TABLE donation_bag ADD CONSTRAINT FK_89021E9A800DF22B FOREIGN KEY (donation_bag_donator_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE donation_bag ADD CONSTRAINT FK_89021E9A467628FF FOREIGN KEY (donation_bag_process_status_id) REFERENCES process_satus (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_color DROP FOREIGN KEY FK_11E13AF87294869C');
        $this->addSql('ALTER TABLE article_fabric DROP FOREIGN KEY FK_724E7237294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A25214E1');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E664F4F96F2');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_color');
        $this->addSql('DROP TABLE article_fabric');
        $this->addSql('DROP TABLE delivery_bag');
        $this->addSql('DROP TABLE donation_bag');
    }
}
