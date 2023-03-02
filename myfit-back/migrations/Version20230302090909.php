<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302090909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE user CHANGE age age VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE height height VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE objectif_weight objectif_weight VARCHAR(255) DEFAULT NULL');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE age age INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE gender gender INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE height height INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE objectif_weight objectif_weight INT DEFAULT NULL');
    }
}
