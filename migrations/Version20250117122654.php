<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117122654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $hashedPassword = password_hash('2PHfA,DK/06b)|N5dKX>!|ch', PASSWORD_BCRYPT);

        $this->addSql("
        INSERT INTO user (username, password, email) 
        VALUES ('anonymous_user', '$hashedPassword', 'anonymous@example.com')
    ");

        $this->addSql("
        UPDATE task 
        SET user_id = (SELECT id FROM user WHERE username = 'anonymous_user') 
        WHERE user_id IS NULL
    ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("
        UPDATE task 
        SET user_id = NULL 
        WHERE user_id = (SELECT id FROM user WHERE username = 'anonymous_user')
    ");

        $this->addSql("
        DELETE FROM user 
        WHERE username = 'anonymous_user'
    ");
    }
}
