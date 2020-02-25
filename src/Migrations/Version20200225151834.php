<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225151834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE ingredients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(150) NOT NULL)');
        $this->addSql('CREATE TABLE media (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A2CA10C59D8A214 ON media (recipe_id)');
        $this->addSql('CREATE TABLE recipe_ingredients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER NOT NULL, ingredient_id INTEGER NOT NULL, quantity VARCHAR(150) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9F925F2B59D8A214 ON recipe_ingredients (recipe_id)');
        $this->addSql('CREATE INDEX IDX_9F925F2B933FE08C ON recipe_ingredients (ingredient_id)');
        $this->addSql('CREATE TABLE recipes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, preparation_duration TIME NOT NULL, baking_duration TIME NOT NULL, additional_infos CLOB DEFAULT NULL, rating_stars INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_A369E2B5A76ED395 ON recipes (user_id)');
        $this->addSql('CREATE TABLE recipe_steps (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER NOT NULL, step_id INTEGER NOT NULL, step_order INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_2231DE6D59D8A214 ON recipe_steps (recipe_id)');
        $this->addSql('CREATE INDEX IDX_2231DE6D73B21E9C ON recipe_steps (step_id)');
        $this->addSql('CREATE TABLE steps (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(150) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(150) NOT NULL, password VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE recipe_ingredients');
        $this->addSql('DROP TABLE recipes');
        $this->addSql('DROP TABLE recipe_steps');
        $this->addSql('DROP TABLE steps');
        $this->addSql('DROP TABLE users');
    }
}
