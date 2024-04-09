<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218171721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre_relais_user DROP FOREIGN KEY FK_9C56AF43AC2504A9');
        $this->addSql('ALTER TABLE centre_relais_user DROP FOREIGN KEY FK_9C56AF43A76ED395');
        $this->addSql('DROP TABLE centre_relais_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre_relais_user (centre_relais_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9C56AF43A76ED395 (user_id), INDEX IDX_9C56AF43AC2504A9 (centre_relais_id), PRIMARY KEY(centre_relais_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE centre_relais_user ADD CONSTRAINT FK_9C56AF43AC2504A9 FOREIGN KEY (centre_relais_id) REFERENCES centre_relais (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE centre_relais_user ADD CONSTRAINT FK_9C56AF43A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
