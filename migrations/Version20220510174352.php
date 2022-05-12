<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510174352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF1479F37AE5');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF1479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF1479F37AE5');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF1479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }
}
