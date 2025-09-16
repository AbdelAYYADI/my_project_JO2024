<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910183824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, book_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', gross_price DOUBLE PRECISION NOT NULL, net_price DOUBLE PRECISION NOT NULL, rate_discount SMALLINT NOT NULL, nbr_person SMALLINT NOT NULL, is_confirmed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA73301C60 ON event (booking_id)');
        $this->addSql('ALTER TABLE price_offer ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price_offer ADD CONSTRAINT FK_21F8F5E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_21F8F5E3301C60 ON price_offer (booking_id)');
        $this->addSql('ALTER TABLE user ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493301C60 ON user (booking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73301C60');
        $this->addSql('ALTER TABLE price_offer DROP FOREIGN KEY FK_21F8F5E3301C60');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6493301C60');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP INDEX IDX_3BAE0AA73301C60 ON event');
        $this->addSql('ALTER TABLE event DROP booking_id');
        $this->addSql('DROP INDEX IDX_21F8F5E3301C60 ON price_offer');
        $this->addSql('ALTER TABLE price_offer DROP booking_id');
        $this->addSql('DROP INDEX IDX_8D93D6493301C60 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP booking_id');
    }
}
