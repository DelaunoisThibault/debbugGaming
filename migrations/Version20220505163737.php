<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505163737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CCF1F1BAB4E2EECF ON editor (editor_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C649DEBFB ON game (name_game)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_CCF1F1BAB4E2EECF ON editor');
        $this->addSql('DROP INDEX UNIQ_232B318C649DEBFB ON game');
    }
}
