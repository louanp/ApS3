<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003135850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF285C0F37DD6');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, le_casier_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, type_notif VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649BD210531 (le_casier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_notif_client (user_id INT NOT NULL, notif_client_id INT NOT NULL, INDEX IDX_43ABE00CA76ED395 (user_id), INDEX IDX_43ABE00C62FDD914 (notif_client_id), PRIMARY KEY(user_id, notif_client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BD210531 FOREIGN KEY (le_casier_id) REFERENCES casier (id)');
        $this->addSql('ALTER TABLE user_notif_client ADD CONSTRAINT FK_43ABE00CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_notif_client ADD CONSTRAINT FK_43ABE00C62FDD914 FOREIGN KEY (notif_client_id) REFERENCES notif_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_notif_client DROP FOREIGN KEY FK_726D3E0F19EB6921');
        $this->addSql('ALTER TABLE client_notif_client DROP FOREIGN KEY FK_726D3E0F62FDD914');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_notif_client');
        $this->addSql('DROP INDEX UNIQ_3FDF285C0F37DD6 ON casier');
        $this->addSql('ALTER TABLE casier DROP le_client_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, tel VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type_notif VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client_notif_client (client_id INT NOT NULL, notif_client_id INT NOT NULL, INDEX IDX_726D3E0F62FDD914 (notif_client_id), INDEX IDX_726D3E0F19EB6921 (client_id), PRIMARY KEY(client_id, notif_client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE client_notif_client ADD CONSTRAINT FK_726D3E0F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_notif_client ADD CONSTRAINT FK_726D3E0F62FDD914 FOREIGN KEY (notif_client_id) REFERENCES notif_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BD210531');
        $this->addSql('ALTER TABLE user_notif_client DROP FOREIGN KEY FK_43ABE00CA76ED395');
        $this->addSql('ALTER TABLE user_notif_client DROP FOREIGN KEY FK_43ABE00C62FDD914');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_notif_client');
        $this->addSql('ALTER TABLE casier ADD le_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF285C0F37DD6 FOREIGN KEY (le_client_id) REFERENCES client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3FDF285C0F37DD6 ON casier (le_client_id)');
    }
}
