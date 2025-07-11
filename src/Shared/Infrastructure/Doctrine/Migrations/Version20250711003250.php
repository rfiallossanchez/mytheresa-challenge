<?php

declare(strict_types=1);

namespace Challenge\Shared\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250711003250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        /**
         * Categories
         */
        $this->addSql("
            INSERT INTO category (name) VALUES
            ('boots'),
            ('sandals'),
            ('sneakers');
        ");

        /**
         * Products
         */
        $this->addSql("
            INSERT INTO product (sku, name, category, price_amount, price_currency) VALUES
            ('000001', 'BV Lean leather ankle boots', 'boots', 89000, 'EUR'),
            ('000002', 'BV Lean leather ankle boots', 'boots', 99000, 'EUR'),
            ('000003', 'Ashlington leather ankle boots', 'boots', 71000, 'EUR'),
            ('000004', 'Naima embellished suede sandals', 'sandals', 79500, 'EUR'),
            ('000005', 'Nathane leather sneakers', 'sneakers', 59000, 'EUR');
        ");

        /**
         * Products and Category Discounts
         */
        $this->addSql("
            INSERT INTO discount (id, percentage) VALUES
            ('discount-boots-30', 30),
            ('discount-sku-000003-15', 15);
        ");

        $this->addSql("
        INSERT INTO product_discount (product_sku, discount_id) VALUES
            ('000003', 'discount-sku-000003-15');
        ");

        $this->addSql("
        INSERT INTO category_discount (category_name, discount_id) VALUES
            ('boots', 'discount-boots-30');
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM product_discount;");
        $this->addSql("DELETE FROM category_discount;");
        $this->addSql("DELETE FROM discount;");
        $this->addSql("DELETE FROM product;");
        $this->addSql("DELETE FROM category;");
    }
}
