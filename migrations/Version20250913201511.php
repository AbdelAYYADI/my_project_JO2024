<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250913201511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD event_id INT NOT NULL, ADD user_id INT NOT NULL, ADD fulll_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE71F7E88B ON booking (event_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73301C60');
        $this->addSql('DROP INDEX IDX_3BAE0AA73301C60 ON event');
        $this->addSql('ALTER TABLE event DROP booking_id');
        $this->addSql('ALTER TABLE price_offer DROP FOREIGN KEY FK_21F8F5E3301C60');
        $this->addSql('DROP INDEX IDX_21F8F5E3301C60 ON price_offer');
        $this->addSql('ALTER TABLE price_offer DROP booking_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493301C60');
        $this->addSql('DROP INDEX IDX_8D93D6493301C60 ON user');
        $this->addSql('ALTER TABLE user DROP booking_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE71F7E88B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP INDEX IDX_E00CEDDE71F7E88B ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('ALTER TABLE booking DROP event_id, DROP user_id, DROP fulll_name');
        $this->addSql('ALTER TABLE event ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA73301C60 ON event (booking_id)');
        $this->addSql('ALTER TABLE price_offer ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price_offer ADD CONSTRAINT FK_21F8F5E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_21F8F5E3301C60 ON price_offer (booking_id)');
        $this->addSql('ALTER TABLE `user` ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6493301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493301C60 ON `user` (booking_id)');
    }
}
