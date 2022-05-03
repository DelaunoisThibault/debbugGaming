<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501124550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug ADD id_bug_fix_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF145B91E7A0 FOREIGN KEY (id_bug_fix_id) REFERENCES bug_fix (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_358CBF145B91E7A0 ON bug (id_bug_fix_id)');
        $this->addSql('ALTER TABLE bug_fix DROP FOREIGN KEY FK_C46D341BDC0A0638');
        $this->addSql('DROP INDEX UNIQ_C46D341BDC0A0638 ON bug_fix');
        $this->addSql('ALTER TABLE bug_fix DROP id_bug_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF145B91E7A0');
        $this->addSql('DROP INDEX UNIQ_358CBF145B91E7A0 ON bug');
        $this->addSql('ALTER TABLE bug DROP id_bug_fix_id');
        $this->addSql('ALTER TABLE bug_fix ADD id_bug_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug_fix ADD CONSTRAINT FK_C46D341BDC0A0638 FOREIGN KEY (id_bug_id) REFERENCES bug (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C46D341BDC0A0638 ON bug_fix (id_bug_id)');
    }
}
