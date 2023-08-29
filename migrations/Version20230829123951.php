<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829123951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE84DDC6B4');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_user (favorite_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6395CF76AA17481D (favorite_id), INDEX IDX_6395CF76A76ED395 (user_id), PRIMARY KEY(favorite_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_property (favorite_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_21A5042FAA17481D (favorite_id), INDEX IDX_21A5042F549213EC (property_id), PRIMARY KEY(favorite_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_user ADD CONSTRAINT FK_6395CF76AA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_user ADD CONSTRAINT FK_6395CF76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_property ADD CONSTRAINT FK_21A5042FAA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_property ADD CONSTRAINT FK_21A5042F549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F579F37AE5');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP INDEX IDX_8BF21CDE84DDC6B4 ON property');
        $this->addSql('ALTER TABLE property DROP favorites_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, INDEX IDX_E46960F579F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite_user DROP FOREIGN KEY FK_6395CF76AA17481D');
        $this->addSql('ALTER TABLE favorite_user DROP FOREIGN KEY FK_6395CF76A76ED395');
        $this->addSql('ALTER TABLE favorite_property DROP FOREIGN KEY FK_21A5042FAA17481D');
        $this->addSql('ALTER TABLE favorite_property DROP FOREIGN KEY FK_21A5042F549213EC');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE favorite_user');
        $this->addSql('DROP TABLE favorite_property');
        $this->addSql('ALTER TABLE property ADD favorites_id INT NOT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE84DDC6B4 FOREIGN KEY (favorites_id) REFERENCES favorites (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDE84DDC6B4 ON property (favorites_id)');
    }
}
