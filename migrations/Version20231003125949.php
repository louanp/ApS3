<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003125949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE casier (id INT AUTO_INCREMENT NOT NULL, le_centre_relais_id INT DEFAULT NULL, le_client_id INT DEFAULT NULL, disponibilite TINYINT(1) NOT NULL, lib VARCHAR(255) NOT NULL, longueur DOUBLE PRECISION NOT NULL, largeur DOUBLE PRECISION NOT NULL, hauteur DOUBLE PRECISION NOT NULL, INDEX IDX_3FDF2859E776A23 (le_centre_relais_id), UNIQUE INDEX UNIQ_3FDF285C0F37DD6 (le_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_relais (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, capacite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, type_notif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_notif_client (client_id INT NOT NULL, notif_client_id INT NOT NULL, INDEX IDX_726D3E0F19EB6921 (client_id), INDEX IDX_726D3E0F62FDD914 (notif_client_id), PRIMARY KEY(client_id, notif_client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, poid DOUBLE PRECISION NOT NULL, destination VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, estimation_livraison DATETIME NOT NULL, date_commande DATETIME NOT NULL, longueur DOUBLE PRECISION NOT NULL, largeur DOUBLE PRECISION NOT NULL, hauteur DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_notif_client (commande_id INT NOT NULL, notif_client_id INT NOT NULL, INDEX IDX_F99B3C4582EA2E54 (commande_id), INDEX IDX_F99B3C4562FDD914 (notif_client_id), PRIMARY KEY(commande_id, notif_client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, la_commande_id INT DEFAULT NULL, lib VARCHAR(255) NOT NULL, INDEX IDX_55CAF7623743EDD (la_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notif_client (id INT AUTO_INCREMENT NOT NULL, lib VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notif_relais (id INT AUTO_INCREMENT NOT NULL, le_centre_relais_id INT DEFAULT NULL, lib VARCHAR(255) NOT NULL, INDEX IDX_E70F74CB9E776A23 (le_centre_relais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF2859E776A23 FOREIGN KEY (le_centre_relais_id) REFERENCES centre_relais (id)');
        $this->addSql('ALTER TABLE casier ADD CONSTRAINT FK_3FDF285C0F37DD6 FOREIGN KEY (le_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_notif_client ADD CONSTRAINT FK_726D3E0F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_notif_client ADD CONSTRAINT FK_726D3E0F62FDD914 FOREIGN KEY (notif_client_id) REFERENCES notif_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_notif_client ADD CONSTRAINT FK_F99B3C4582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_notif_client ADD CONSTRAINT FK_F99B3C4562FDD914 FOREIGN KEY (notif_client_id) REFERENCES notif_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etat ADD CONSTRAINT FK_55CAF7623743EDD FOREIGN KEY (la_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE notif_relais ADD CONSTRAINT FK_E70F74CB9E776A23 FOREIGN KEY (le_centre_relais_id) REFERENCES centre_relais (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF2859E776A23');
        $this->addSql('ALTER TABLE casier DROP FOREIGN KEY FK_3FDF285C0F37DD6');
        $this->addSql('ALTER TABLE client_notif_client DROP FOREIGN KEY FK_726D3E0F19EB6921');
        $this->addSql('ALTER TABLE client_notif_client DROP FOREIGN KEY FK_726D3E0F62FDD914');
        $this->addSql('ALTER TABLE commande_notif_client DROP FOREIGN KEY FK_F99B3C4582EA2E54');
        $this->addSql('ALTER TABLE commande_notif_client DROP FOREIGN KEY FK_F99B3C4562FDD914');
        $this->addSql('ALTER TABLE etat DROP FOREIGN KEY FK_55CAF7623743EDD');
        $this->addSql('ALTER TABLE notif_relais DROP FOREIGN KEY FK_E70F74CB9E776A23');
        $this->addSql('DROP TABLE casier');
        $this->addSql('DROP TABLE centre_relais');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_notif_client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_notif_client');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE notif_client');
        $this->addSql('DROP TABLE notif_relais');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
