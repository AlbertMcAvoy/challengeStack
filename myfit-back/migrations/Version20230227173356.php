<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227173356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `food_group` (`id`, `libelle`) VALUES
        (1, 'entrées et plats composés'),
        (2, 'fruits, légumes, légumineuses et oléagineux'),
        (3, 'produits céréaliers'),
        (4, 'viandes, œufs, poissons et assimilés'),
        (5, 'produits laitiers et assimilés'),
        (6, 'eaux et autres boissons'),
        (7, 'produits sucrés'),
        (8, 'glaces et sorbets'),
        (9, 'matières grasses'),
        (10, 'aides culinaires et ingrédients divers'),
        (11, 'aliments infantiles'),
        (12, 'NULL')");
        $this->addSql("INSERT INTO `food_sub_group` (`id`, `libelle`) VALUES
        (101, 'salades composées et crudités'),
        (102, 'soupes'),
        (103, 'plats composés'),
        (104, 'pizzas, tartes et crêpes salées'),
        (105, 'sandwichs'),
        (106, 'feuilletées et autres entrées'),
        (201, 'légumes'),
        (202, 'pommes de terre et autres tubercules'),
        (203, 'légumineuses'),
        (204, 'fruits'),
        (205, 'fruits à coque et graines oléagineuses'),
        (301, 'pâtes, riz et céréales'),
        (302, 'pains et assimilés'),
        (303, 'biscuits apéritifs'),
        (401, 'viandes cuites'),
        (402, 'viandes crues'),
        (403, 'charcuteries et assimilés'),
        (404, 'autres produits à base de viande'),
        (405, 'poissons cuits'),
        (406, 'poissons crus'),
        (407, 'mollusques et crustacés cuits'),
        (408, 'mollusques et crustacés crus'),
        (409, 'produits à base de poissons et produits de la mer'),
        (410, 'œufs'),
        (411, 'substitus de produits carnés'),
        (501, 'laits'),
        (502, 'produits laitiers frais et assimilés'),
        (503, 'fromages et assimilés'),
        (504, 'crèmes et spécialités à base de crème'),
        (601, 'eaux'),
        (602, 'boissons sans alcool'),
        (603, 'boisson alcoolisées'),
        (701, 'sucres, miels et assimilés'),
        (702, 'chocolats et produits à base de chocolat'),
        (703, 'confiseries non chocolatées'),
        (704, 'confitures et assimilés'),
        (705, 'viennoiseries'),
        (706, 'biscuits sucrés'),
        (707, 'céréales de petit-déjeuner'),
        (708, 'barres céréalières'),
        (709, 'gâteaux et pâtisseries'),
        (0, '-0'),
        (801, 'glaces'),
        (802, 'sorbets'),
        (803, 'desserts glacés'),
        (901, 'beurres'),
        (902, 'huiles et graisses végétales'),
        (903, 'margarines'),
        (904, 'huiles de poissons'),
        (905, 'autres matières grasses'),
        (1001, 'sauces'),
        (1002, 'condiments'),
        (1003, 'aides culinaires'),
        (1004, 'sels'),
        (1005, 'épices'),
        (1006, 'herbes'),
        (1007, 'algues'),
        (1008, 'denrées destinées à une alimentation particulière'),
        (1009, 'aides culinaires et ingrédients pour végétariens'),
        (1101, 'laits et boissons infantiles'),
        (1102, 'petits pots salés et plats infantiles'),
        (1103, 'desserts infantiles'),
        (1104, 'céréales et biscuits infantiles'),
        (1105, 'NULL')");
        $this->addSql("INSERT INTO `food_sub_sub_group` (`id`, `libelle`) VALUES
        (0, 'NULL'),
        (10301, 'plats de viande sans garniture'),
        (10302, 'plats de viande et féculents'),
        (10303, 'plats de viande et légumes/légumineuses'),
        (10304, 'plats de poisson sans garniture'),
        (10305, 'plats de poisson et féculents'),
        (10306, 'plats de légumes/légumineuses'),
        (10307, 'plats de céréales/pâtes'),
        (10308, 'plats de fromage'),
        (10309, 'plats végétariens'),
        (20101, 'légumes crus'),
        (20102, 'légumes cuits'),
        (20103, 'légumes séchés ou déshydratés'),
        (20104, 'légumes et leurs produits de la Martinique'),
        (20105, 'légumes et leurs produits de la Réunion'),
        (20301, 'légumineuses cuites'),
        (20302, 'légumineuses fraîches'),
        (20303, 'légumineuses sèches'),
        (20401, 'fruits crus'),
        (20402, 'compotes et assimilés'),
        (20403, 'fruits appertisés'),
        (20404, 'fruits séchés'),
        (20405, 'fruits et leurs produits de la Martinique'),
        (20406, 'fruits et leurs produits de la Réunion'),
        (30101, 'pâtes, riz et céréales cuits'),
        (30102, 'pâtes, riz et céréales crus'),
        (30201, 'pains'),
        (30202, 'biscottes et pains grillés'),
        (40101, 'bœuf et veau'),
        (40102, 'porc'),
        (40103, 'poulet'),
        (40104, 'dinde'),
        (40105, 'agneau et mouton'),
        (40106, 'gibier'),
        (40107, 'autres viandes'),
        (40108, 'abats'),
        (40201, 'bœuf et veau'),
        (40202, 'porc'),
        (40203, 'poulet'),
        (40204, 'dinde'),
        (40205, 'agneau et mouton'),
        (40206, 'gibier'),
        (40207, 'autres viandes'),
        (40208, 'abats'),
        (40301, 'jambons cuits'),
        (40302, 'jambons secs et crus'),
        (40303, 'saucisson secs'),
        (40304, 'saucisses et assimilés'),
        (40305, 'pâtés et terrines'),
        (40306, 'rillettes'),
        (40307, 'quenelles'),
        (40308, 'autres spécialités charcutières'),
        (40309, 'substituts de charcuteries pour végétariens'),
        (41001, 'œufs cuits'),
        (41002, 'œufs crus'),
        (41003, 'omelettes et autres ovoproduits'),
        (50101, 'laits de vaches liquides (non concentrés)'),
        (50102, 'laits autres que de vache'),
        (50103, 'laits de vache concentrés ou en poudre'),
        (50201, 'yaourts et spécialités laitières type yaourt'),
        (50202, 'fromages blancs'),
        (50203, 'desserts lactés'),
        (50204, 'autres desserts'),
        (50205, 'desserts végétaux'),
        (50301, 'fromages à pâte molle'),
        (50302, 'fromages à pâte persillée'),
        (50303, 'fromages à pâte pressée'),
        (50304, 'fromage fondus'),
        (50305, 'autres fromages et spécialités'),
        (50306, 'substituts de fromages pour végétariens'),
        (60201, 'jus'),
        (60202, 'nectars'),
        (60203, 'boissons rafraîchissantes sans alcool'),
        (60204, 'boissons rafraîchissantes lactées'),
        (60205, 'boissons végétales'),
        (60206, 'café, thé, cacao etc. prêts à consommer'),
        (60207, 'boissons à reconstituer'),
        (60301, 'vins'),
        (60302, 'bières et cidres'),
        (60303, 'liqueurs et alcools'),
        (60304, 'cocktails'),
        (100101, 'sauces condimentaires'),
        (100102, 'sauces chaudes'),
        (100103, 'sauces sucrées'),
        (100601, 'herbes fraîches'),
        (100602, 'herbes séchées')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("TRUNCATE TABLE food_group");
        $this->addSql("TRUNCATE TABLE food_sub_group");
        $this->addSql("TRUNCATE TABLE food_sub_sub_group");

    }
}
