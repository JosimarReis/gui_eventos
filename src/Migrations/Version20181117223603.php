<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181117223603 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cidade (id INT AUTO_INCREMENT NOT NULL, estado_id INT DEFAULT NULL, nome VARCHAR(45) NOT NULL, INDEX IDX_6A98335C9F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, respostas_id INT DEFAULT NULL, comentario LONGTEXT NOT NULL, data DATETIME NOT NULL, INDEX IDX_4B91E702DB38439E (usuario_id), INDEX IDX_4B91E7027FDA64EB (respostas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, categoria_id INT DEFAULT NULL, local_id INT DEFAULT NULL, nome VARCHAR(60) NOT NULL, data DATETIME NOT NULL, descricao LONGTEXT NOT NULL, visitas INT NOT NULL, INDEX IDX_47860B05DB38439E (usuario_id), INDEX IDX_47860B053397707A (categoria_id), INDEX IDX_47860B055D5A2101 (local_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagem (id INT AUTO_INCREMENT NOT NULL, imagem LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE local (id INT AUTO_INCREMENT NOT NULL, cidade_id INT DEFAULT NULL, logradouro VARCHAR(255) NOT NULL, numero VARCHAR(10) NOT NULL, complemento VARCHAR(255) NOT NULL, INDEX IDX_8BD688E89586CC8 (cidade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, senha VARCHAR(255) NOT NULL, perfil VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cidade ADD CONSTRAINT FK_6A98335C9F5A440B FOREIGN KEY (estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E7027FDA64EB FOREIGN KEY (respostas_id) REFERENCES comentario (id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B053397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B055D5A2101 FOREIGN KEY (local_id) REFERENCES local (id)');
        $this->addSql('ALTER TABLE local ADD CONSTRAINT FK_8BD688E89586CC8 FOREIGN KEY (cidade_id) REFERENCES cidade (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B053397707A');
        $this->addSql('ALTER TABLE local DROP FOREIGN KEY FK_8BD688E89586CC8');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E7027FDA64EB');
        $this->addSql('ALTER TABLE cidade DROP FOREIGN KEY FK_6A98335C9F5A440B');
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B055D5A2101');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702DB38439E');
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B05DB38439E');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE cidade');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('DROP TABLE estado');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE imagem');
        $this->addSql('DROP TABLE local');
        $this->addSql('DROP TABLE usuario');
    }
}
