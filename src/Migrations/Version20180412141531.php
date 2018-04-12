<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412141531 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE workshop (id INT AUTO_INCREMENT NOT NULL, workshop_trainer_id INT NOT NULL, workshop_date DATETIME NOT NULL, workshop_theme VARCHAR(255) NOT NULL, workshop_fee DOUBLE PRECISION NOT NULL, workshop_place VARCHAR(500) DEFAULT NULL, workshop_picture VARCHAR(255) DEFAULT NULL, INDEX IDX_9B6F02C47CF67493 (workshop_trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_member (workshop_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_8D6E81511FDCE57C (workshop_id), INDEX IDX_8D6E81517597D3FE (member_id), PRIMARY KEY(workshop_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workshop ADD CONSTRAINT FK_9B6F02C47CF67493 FOREIGN KEY (workshop_trainer_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE workshop_member ADD CONSTRAINT FK_8D6E81511FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_member ADD CONSTRAINT FK_8D6E81517597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE workshop_member DROP FOREIGN KEY FK_8D6E81511FDCE57C');
        $this->addSql('DROP TABLE workshop');
        $this->addSql('DROP TABLE workshop_member');
    }
}
