<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170621220346 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE instrument (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrument_mappings (instrument_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', mapping_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_B783E318CF11D9C (instrument_id), UNIQUE INDEX UNIQ_B783E318FABB77CC (mapping_id), PRIMARY KEY(instrument_id, mapping_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jammer (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL COMMENT \'email address\', alias VARCHAR(255) NOT NULL COMMENT \'alias name\', password VARCHAR(255) NOT NULL COMMENT \'password\', roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', enabled TINYINT(1) NOT NULL COMMENT \'user is enabled or not\', locked TINYINT(1) NOT NULL COMMENT \'account is locked or not\', expired TINYINT(1) NOT NULL COMMENT \'account is expired or not\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', jammer_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', tempo SMALLINT NOT NULL COMMENT \'tempo of the session in BPM\', label VARCHAR(255) NOT NULL COMMENT \'the session label\', description LONGTEXT DEFAULT NULL COMMENT \'a exhaustive description of the session\', INDEX IDX_D044D5D464EA0218 (jammer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_tracks (session_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', track_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_4B062077613FECDF (session_id), UNIQUE INDEX UNIQ_4B0620775ED23C43 (track_id), PRIMARY KEY(session_id, track_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mapping (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sample_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', `range` LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_49E62C8A1B1FEA20 (sample_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sample (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', updated_at DATETIME NOT NULL, sound_name VARCHAR(255) DEFAULT NULL, sound_original_name VARCHAR(255) DEFAULT NULL, sound_mime_type VARCHAR(255) DEFAULT NULL, sound_size INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', instrument_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_D6E3F8A6CF11D9C (instrument_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instrument_mappings ADD CONSTRAINT FK_B783E318CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE instrument_mappings ADD CONSTRAINT FK_B783E318FABB77CC FOREIGN KEY (mapping_id) REFERENCES mapping (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D464EA0218 FOREIGN KEY (jammer_id) REFERENCES jammer (id)');
        $this->addSql('ALTER TABLE session_tracks ADD CONSTRAINT FK_4B062077613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session_tracks ADD CONSTRAINT FK_4B0620775ED23C43 FOREIGN KEY (track_id) REFERENCES track (id)');
        $this->addSql('ALTER TABLE mapping ADD CONSTRAINT FK_49E62C8A1B1FEA20 FOREIGN KEY (sample_id) REFERENCES sample (id)');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A6CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE instrument_mappings DROP FOREIGN KEY FK_B783E318CF11D9C');
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A6CF11D9C');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D464EA0218');
        $this->addSql('ALTER TABLE session_tracks DROP FOREIGN KEY FK_4B062077613FECDF');
        $this->addSql('ALTER TABLE instrument_mappings DROP FOREIGN KEY FK_B783E318FABB77CC');
        $this->addSql('ALTER TABLE mapping DROP FOREIGN KEY FK_49E62C8A1B1FEA20');
        $this->addSql('ALTER TABLE session_tracks DROP FOREIGN KEY FK_4B0620775ED23C43');
        $this->addSql('DROP TABLE instrument');
        $this->addSql('DROP TABLE instrument_mappings');
        $this->addSql('DROP TABLE jammer');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_tracks');
        $this->addSql('DROP TABLE mapping');
        $this->addSql('DROP TABLE sample');
        $this->addSql('DROP TABLE track');
    }
}
