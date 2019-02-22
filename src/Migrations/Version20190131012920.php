<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131012920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE simple_user ADD donneur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE simple_user ADD CONSTRAINT FK_2272B4F09789825B FOREIGN KEY (donneur_id) REFERENCES donneur (id)');
        $this->addSql('CREATE INDEX IDX_2272B4F09789825B ON simple_user (donneur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE simple_user DROP FOREIGN KEY FK_2272B4F09789825B');
        $this->addSql('DROP INDEX IDX_2272B4F09789825B ON simple_user');
        $this->addSql('ALTER TABLE simple_user DROP donneur_id');
    }
}
