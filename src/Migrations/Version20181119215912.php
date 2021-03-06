<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181119215912 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento CHANGE data data DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE visitas visitas INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE imagem CHANGE imagem imagem VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE nome nome VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento CHANGE data data DATETIME NOT NULL, CHANGE visitas visitas INT NOT NULL');
        $this->addSql('ALTER TABLE imagem CHANGE imagem imagem LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE usuario CHANGE nome nome VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
