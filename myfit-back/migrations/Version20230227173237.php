<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227173237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE body (id INT AUTO_INCREMENT NOT NULL, weight INT DEFAULT NULL, date_time DATETIME NOT NULL, objectif_weight INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food (id INT AUTO_INCREMENT NOT NULL, group_id_id INT NOT NULL, sub_group_id_id INT NOT NULL, sub_sub_group_id_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, calories INT DEFAULT NULL, energy INT DEFAULT NULL, water INT DEFAULT NULL, protein INT DEFAULT NULL, glucid INT DEFAULT NULL, lipid INT DEFAULT NULL, sugar INT DEFAULT NULL, ag_sature INT DEFAULT NULL, cholesterol INT DEFAULT NULL, calcium INT DEFAULT NULL, fer INT DEFAULT NULL, magnesium INT DEFAULT NULL, sodium INT DEFAULT NULL, INDEX IDX_D43829F72F68B530 (group_id_id), INDEX IDX_D43829F7CA91C0AE (sub_group_id_id), INDEX IDX_D43829F7D02AB081 (sub_sub_group_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_group (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_sub_group (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_sub_sub_group (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F72F68B530 FOREIGN KEY (group_id_id) REFERENCES food_group (id)');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F7CA91C0AE FOREIGN KEY (sub_group_id_id) REFERENCES food_sub_group (id)');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F7D02AB081 FOREIGN KEY (sub_sub_group_id_id) REFERENCES food_sub_sub_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F72F68B530');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F7CA91C0AE');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F7D02AB081');
        $this->addSql('DROP TABLE body');
        $this->addSql('DROP TABLE food');
        $this->addSql('DROP TABLE food_group');
        $this->addSql('DROP TABLE food_sub_group');
        $this->addSql('DROP TABLE food_sub_sub_group');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
