<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221025081758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change length for category name and movie title';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE movie CHANGE title title VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movie CHANGE title title VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(30) NOT NULL');
    }
}
