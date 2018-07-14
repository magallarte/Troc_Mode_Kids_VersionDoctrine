<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409104644 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, member_name VARCHAR(255) NOT NULL, member_surname VARCHAR(255) NOT NULL, member_address1 VARCHAR(255) DEFAULT NULL, member_address2 VARCHAR(255) DEFAULT NULL, member_zip_code VARCHAR(255) DEFAULT NULL, member_city VARCHAR(255) DEFAULT NULL, member_tel VARCHAR(255) DEFAULT NULL, member_email VARCHAR(255) NOT NULL, member_password VARCHAR(255) NOT NULL, member_button_wallet INT DEFAULT NULL, member_subscription TINYINT(1) NOT NULL, member_expertise VARCHAR(255) DEFAULT NULL, member_level VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_kid (member_id INT NOT NULL, kid_id INT NOT NULL, INDEX IDX_7487A8277597D3FE (member_id), INDEX IDX_7487A8276A973770 (kid_id), PRIMARY KEY(member_id, kid_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member_kid ADD CONSTRAINT FK_7487A8277597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_kid ADD CONSTRAINT FK_7487A8276A973770 FOREIGN KEY (kid_id) REFERENCES kid (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member_kid DROP FOREIGN KEY FK_7487A8277597D3FE');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_kid');
    }
}
