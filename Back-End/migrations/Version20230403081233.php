<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403081233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, joboffer_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, statut INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2694D7A5BD612208 (joboffer_id), INDEX IDX_2694D7A58D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5BD612208 FOREIGN KEY (joboffer_id) REFERENCES job_offer (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A58D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE job_offer ADD salary_min VARCHAR(255) NOT NULL, ADD salary_max VARCHAR(255) NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD currency_position VARCHAR(255) NOT NULL, ADD qualifications VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD full_adress VARCHAR(255) NOT NULL, DROP study, DROP location');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5BD612208');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A58D0EB82');
        $this->addSql('DROP TABLE demande');
        $this->addSql('ALTER TABLE job_offer ADD study VARCHAR(255) NOT NULL, ADD location VARCHAR(255) NOT NULL, DROP salary_min, DROP salary_max, DROP state, DROP currency_position, DROP qualifications, DROP country, DROP city, DROP full_adress');
    }
}
