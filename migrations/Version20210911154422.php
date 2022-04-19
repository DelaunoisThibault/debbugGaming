<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210911154422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bug (id INT AUTO_INCREMENT NOT NULL, id_game_id INT NOT NULL, id_user_id INT NOT NULL, title_bug VARCHAR(255) NOT NULL, subtitle_bug VARCHAR(255) NOT NULL, small_text_bug VARCHAR(255) NOT NULL, description_text_bug LONGTEXT NOT NULL, description_img_bug VARCHAR(255) NOT NULL, severity_bug VARCHAR(255) NOT NULL, frequency_bug VARCHAR(255) NOT NULL, published TINYINT(1) NOT NULL, INDEX IDX_358CBF143A127075 (id_game_id), INDEX IDX_358CBF1479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_fix (id INT AUTO_INCREMENT NOT NULL, id_bug_id INT NOT NULL, resolved TINYINT(1) NOT NULL, maj_number INT NOT NULL, date_bug_fix DATETIME NOT NULL, UNIQUE INDEX UNIQ_C46D341BDC0A0638 (id_bug_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_solution (id INT AUTO_INCREMENT NOT NULL, id_bug_id INT NOT NULL, text_bug_solution LONGTEXT NOT NULL, img_bug_solution VARCHAR(255) NOT NULL, INDEX IDX_5408AD55DC0A0638 (id_bug_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_bug_id INT NOT NULL, text_comments LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_9474526C79F37AE5 (id_user_id), INDEX IDX_9474526CDC0A0638 (id_bug_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, name_contact_message VARCHAR(255) NOT NULL, mail_contact VARCHAR(255) NOT NULL, text_contact_message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, editor_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, id_editor_id INT NOT NULL, name_game VARCHAR(255) NOT NULL, year_of_publication INT NOT NULL, bug_rating VARCHAR(255) NOT NULL, INDEX IDX_232B318CE9A0106B (id_editor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudonym VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, locked TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF143A127075 FOREIGN KEY (id_game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF1479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bug_fix ADD CONSTRAINT FK_C46D341BDC0A0638 FOREIGN KEY (id_bug_id) REFERENCES bug (id)');
        $this->addSql('ALTER TABLE bug_solution ADD CONSTRAINT FK_5408AD55DC0A0638 FOREIGN KEY (id_bug_id) REFERENCES bug (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CDC0A0638 FOREIGN KEY (id_bug_id) REFERENCES bug (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE9A0106B FOREIGN KEY (id_editor_id) REFERENCES editor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug_fix DROP FOREIGN KEY FK_C46D341BDC0A0638');
        $this->addSql('ALTER TABLE bug_solution DROP FOREIGN KEY FK_5408AD55DC0A0638');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CDC0A0638');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE9A0106B');
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF143A127075');
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF1479F37AE5');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C79F37AE5');
        $this->addSql('DROP TABLE bug');
        $this->addSql('DROP TABLE bug_fix');
        $this->addSql('DROP TABLE bug_solution');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE user');
    }
}
