<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409102310 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE kid (id INT AUTO_INCREMENT NOT NULL, kid_school_id_id INT DEFAULT NULL, kid_name VARCHAR(255) NOT NULL, kid_surname VARCHAR(255) NOT NULL, kid_birthday DATE DEFAULT NULL, INDEX IDX_4523887CDA8DB3B7 (kid_school_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, school_name VARCHAR(255) NOT NULL, school_address1 VARCHAR(255) DEFAULT NULL, school_address2 VARCHAR(255) DEFAULT NULL, school_zip_code VARCHAR(255) DEFAULT NULL, school_city VARCHAR(255) NOT NULL, school_director_gender VARCHAR(255) NOT NULL, school_director_name VARCHAR(255) NOT NULL, school_director_tel VARCHAR(255) DEFAULT NULL, school_director_email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kid ADD CONSTRAINT FK_4523887CDA8DB3B7 FOREIGN KEY (kid_school_id_id) REFERENCES school (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kid DROP FOREIGN KEY FK_4523887CDA8DB3B7');
        $this->addSql('DROP TABLE kid');
        $this->addSql('DROP TABLE school');
    }
}
