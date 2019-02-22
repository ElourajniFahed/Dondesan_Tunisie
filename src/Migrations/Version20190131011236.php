<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131011236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE demandeur (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donneur (id INT AUTO_INCREMENT NOT NULL, s_simple_user_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_4493D773FC98DFB8 (s_simple_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE simple_user (id INT AUTO_INCREMENT NOT NULL, demandeur_id INT DEFAULT NULL, datanaissance DATE NOT NULL, email VARCHAR(50) NOT NULL, telephone INT NOT NULL, groupesanguin VARCHAR(50) NOT NULL, INDEX IDX_2272B4F095A6EE59 (demandeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ssimple_user (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, cin INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, fonction VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donneur ADD CONSTRAINT FK_4493D773FC98DFB8 FOREIGN KEY (s_simple_user_id) REFERENCES ssimple_user (id)');
        $this->addSql('ALTER TABLE simple_user ADD CONSTRAINT FK_2272B4F095A6EE59 FOREIGN KEY (demandeur_id) REFERENCES demandeur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE simple_user DROP FOREIGN KEY FK_2272B4F095A6EE59');
        $this->addSql('ALTER TABLE donneur DROP FOREIGN KEY FK_4493D773FC98DFB8');
        $this->addSql('DROP TABLE demandeur');
        $this->addSql('DROP TABLE donneur');
        $this->addSql('DROP TABLE simple_user');
        $this->addSql('DROP TABLE ssimple_user');
        $this->addSql('DROP TABLE utilisateur');
    }
}
