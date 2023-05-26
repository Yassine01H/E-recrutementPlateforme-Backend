<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404084353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, joboffer_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, statut INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2694D7A5BD612208 (joboffer_id), INDEX IDX_2694D7A58D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT DEFAULT NULL, titlejob VARCHAR(255) NOT NULL, expeience VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', salary VARCHAR(255) NOT NULL, contract VARCHAR(255) NOT NULL, salary_min VARCHAR(255) NOT NULL, salary_max VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, currency_position VARCHAR(255) NOT NULL, qualifications VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, full_adress VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_288A3A4E156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5BD612208 FOREIGN KEY (joboffer_id) REFERENCES job_offer (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A58D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5BD612208');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A58D0EB82');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E156BE243');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE job_offer');
    }
}
