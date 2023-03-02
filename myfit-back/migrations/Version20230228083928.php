<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228083928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food_meal (food_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_2BD1264DBA8E87C4 (food_id), INDEX IDX_2BD1264D639666D6 (meal_id), PRIMARY KEY(food_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food_meal ADD CONSTRAINT FK_2BD1264DBA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE food_meal ADD CONSTRAINT FK_2BD1264D639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food_meal DROP FOREIGN KEY FK_2BD1264DBA8E87C4');
        $this->addSql('ALTER TABLE food_meal DROP FOREIGN KEY FK_2BD1264D639666D6');
        $this->addSql('DROP TABLE food_meal');
        $this->addSql('DROP TABLE meal');
    }
}
