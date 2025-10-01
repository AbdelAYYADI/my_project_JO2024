<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930171435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, payment_id INT DEFAULT NULL, book_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', gross_price DOUBLE PRECISION NOT NULL, net_price DOUBLE PRECISION NOT NULL, rate_discount SMALLINT NOT NULL, net_total DOUBLE PRECISION NOT NULL, nbr_person SMALLINT NOT NULL, fulll_name VARCHAR(255) NOT NULL, is_confirmed TINYINT(1) NOT NULL, booking_key BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', person_list LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_E00CEDDE71F7E88B (event_id), INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE4C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, name VARCHAR(30) NOT NULL, title VARCHAR(100) NOT NULL, date_event DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', program_event JSON NOT NULL COMMENT \'(DC2Type:json)\', location VARCHAR(120) NOT NULL, ticket_price DOUBLE PRECISION NOT NULL, INDEX IDX_3BAE0AA7AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games_history (id INT AUTO_INCREMENT NOT NULL, sport VARCHAR(30) NOT NULL, image VARCHAR(30) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date_ticket DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total_price DOUBLE PRECISION NOT NULL, INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_offer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, number_person SMALLINT NOT NULL, rate_discount SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, image VARCHAR(30) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, security_key BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(120) NOT NULL, last_name VARCHAR(120) NOT NULL, adress1 VARCHAR(100) NOT NULL, adress2 VARCHAR(100) DEFAULT NULL, phone_number VARCHAR(14) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(100) NOT NULL, country VARCHAR(100) NOT NULL, is_admin TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE71F7E88B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4C3A3BB');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7AC78BCF8');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE games_history');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE price_offer');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
