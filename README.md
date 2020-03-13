# BDAA

point d'entré => index.php

toutes les méthodes (create, update, get, getList, delete) sont présentes dans index.php

la conf pour la bdd (pgsql) se trouve dans config/dbconfig.ini

pour faire une migration d'une entité, il suffit de renseigner la variable config du fichier correspondant à l'entité en question dans Core\Entity\ORMConfig\Category

