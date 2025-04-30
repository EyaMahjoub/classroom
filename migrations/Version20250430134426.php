<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430134426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe_etudiant (classe_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_4BB0EA4D8F5EA509 (classe_id), INDEX IDX_4BB0EA4DDDEAB1A3 (etudiant_id), PRIMARY KEY(classe_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe_etudiant ADD CONSTRAINT FK_4BB0EA4D8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_etudiant ADD CONSTRAINT FK_4BB0EA4DDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE devoire ADD title VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deadline DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe_etudiant DROP FOREIGN KEY FK_4BB0EA4D8F5EA509');
        $this->addSql('ALTER TABLE classe_etudiant DROP FOREIGN KEY FK_4BB0EA4DDDEAB1A3');
        $this->addSql('DROP TABLE classe_etudiant');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE devoire DROP title, DROP created_at, DROP deadline');
        $this->addSql('ALTER TABLE classe CHANGE image image VARCHAR(255) DEFAULT \'NULL\'');
    }
}
