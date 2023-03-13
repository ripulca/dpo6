<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230311194302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE education_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE resume_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE education (id INT NOT NULL, resume_id INT NOT NULL, level VARCHAR(255) NOT NULL, institution VARCHAR(255) DEFAULT NULL, faculty VARCHAR(255) DEFAULT NULL, specialization VARCHAR(255) DEFAULT NULL, gard_year INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB0A5ED2D262AF09 ON education (resume_id)');
        $this->addSql('CREATE TABLE resume (id INT NOT NULL, status VARCHAR(50) NOT NULL, profession VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, photo VARCHAR(800) NOT NULL, fio VARCHAR(255) NOT NULL, phone VARCHAR(11) NOT NULL, email VARCHAR(255) NOT NULL, bd DATE NOT NULL, age INT NOT NULL, salary INT NOT NULL, skills VARCHAR(500) NOT NULL, about VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE education_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE resume_id_seq CASCADE');
        $this->addSql('ALTER TABLE education DROP CONSTRAINT FK_DB0A5ED2D262AF09');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE resume');
    }
}
