<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181117224345 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentario ADD evento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E70287A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
        $this->addSql('CREATE INDEX IDX_4B91E70287A5F842 ON comentario (evento_id)');
        $this->addSql('ALTER TABLE imagem ADD evento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE imagem ADD CONSTRAINT FK_1A10830987A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
        $this->addSql('CREATE INDEX IDX_1A10830987A5F842 ON imagem (evento_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E70287A5F842');
        $this->addSql('DROP INDEX IDX_4B91E70287A5F842 ON comentario');
        $this->addSql('ALTER TABLE comentario DROP evento_id');
        $this->addSql('ALTER TABLE imagem DROP FOREIGN KEY FK_1A10830987A5F842');
        $this->addSql('DROP INDEX IDX_1A10830987A5F842 ON imagem');
        $this->addSql('ALTER TABLE imagem DROP evento_id');
    }
}
