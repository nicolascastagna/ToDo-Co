<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117142513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update user roles to default ROLE_USER for NULL, empty, or invalid roles';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
            UPDATE user 
            SET roles = '[\"ROLE_USER\"]'
            WHERE roles IS NULL 
               OR TRIM(roles) = 'null' 
               OR TRIM(roles) = '[]' 
               OR TRIM(roles) = ''
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("
            UPDATE user 
            SET roles = NULL
            WHERE roles = '[\"ROLE_USER\"]'
        ");
    }
}
