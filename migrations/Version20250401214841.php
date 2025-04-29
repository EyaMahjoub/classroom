<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401214841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devoire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe ADD enseignant_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96E455FCC0 ON classe (enseignant_id)');
        $this->addSql('ALTER TABLE commentaire ADD enseignant_id INT DEFAULT NULL, ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCE455FCC0 ON commentaire (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_67F068BCDDEAB1A3 ON commentaire (etudiant_id)');
        $this->addSql('ALTER TABLE cours ADD classe_id INT DEFAULT NULL, ADD devoire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C3A25AA2 FOREIGN KEY (devoire_id) REFERENCES devoire (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C8F5EA509 ON cours (classe_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C3A25AA2 ON cours (devoire_id)');
        $this->addSql('ALTER TABLE fichier ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_9B76551F8F5EA509 ON fichier (classe_id)');
        $this->addSql('ALTER TABLE inscription ADD enseignant_id INT DEFAULT NULL, ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6E455FCC0 ON inscription (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6DDEAB1A3 ON inscription (etudiant_id)');
        $this->addSql('ALTER TABLE notification ADD enseignant_id INT DEFAULT NULL, ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAE455FCC0 ON notification (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CADDEAB1A3 ON notification (etudiant_id)');
        $this->addSql('ALTER TABLE soumission_devoire ADD etudiant_id INT DEFAULT NULL, ADD devoire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE soumission_devoire ADD CONSTRAINT FK_DAEEBE4EDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE soumission_devoire ADD CONSTRAINT FK_DAEEBE4E3A25AA2 FOREIGN KEY (devoire_id) REFERENCES devoire (id)');
        $this->addSql('CREATE INDEX IDX_DAEEBE4EDDEAB1A3 ON soumission_devoire (etudiant_id)');
        $this->addSql('CREATE INDEX IDX_DAEEBE4E3A25AA2 ON soumission_devoire (devoire_id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C3A25AA2');
        $this->addSql('ALTER TABLE soumission_devoire DROP FOREIGN KEY FK_DAEEBE4E3A25AA2');
        $this->addSql('DROP TABLE devoire');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96E455FCC0');
        $this->addSql('DROP INDEX IDX_8F87BF96E455FCC0 ON classe');
        $this->addSql('ALTER TABLE classe DROP enseignant_id, CHANGE image image VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCE455FCC0');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCDDEAB1A3');
        $this->addSql('DROP INDEX IDX_67F068BCE455FCC0 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BCDDEAB1A3 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP enseignant_id, DROP etudiant_id');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C8F5EA509');
        $this->addSql('DROP INDEX IDX_FDCA8C9C8F5EA509 ON cours');
        $this->addSql('DROP INDEX IDX_FDCA8C9C3A25AA2 ON cours');
        $this->addSql('ALTER TABLE cours DROP classe_id, DROP devoire_id');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F8F5EA509');
        $this->addSql('DROP INDEX IDX_9B76551F8F5EA509 ON fichier');
        $this->addSql('ALTER TABLE fichier DROP classe_id');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6E455FCC0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6DDEAB1A3');
        $this->addSql('DROP INDEX IDX_5E90F6D6E455FCC0 ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D6DDEAB1A3 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP enseignant_id, DROP etudiant_id');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE455FCC0');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CADDEAB1A3');
        $this->addSql('DROP INDEX IDX_BF5476CAE455FCC0 ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CADDEAB1A3 ON notification');
        $this->addSql('ALTER TABLE notification DROP enseignant_id, DROP etudiant_id');
        $this->addSql('ALTER TABLE soumission_devoire DROP FOREIGN KEY FK_DAEEBE4EDDEAB1A3');
        $this->addSql('DROP INDEX IDX_DAEEBE4EDDEAB1A3 ON soumission_devoire');
        $this->addSql('DROP INDEX IDX_DAEEBE4E3A25AA2 ON soumission_devoire');
        $this->addSql('ALTER TABLE soumission_devoire DROP etudiant_id, DROP devoire_id');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
