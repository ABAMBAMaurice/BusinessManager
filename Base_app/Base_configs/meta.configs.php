<?php
//Inclusion des fichiers

$new_classes = null;
$declared_classes_before = get_declared_classes();

foreach (glob("../Base_app/Tables/*.php") as $filename) {
    require_once $filename;
}

$declared_classes_after = get_declared_classes();
$new_classes = array_diff($declared_classes_after, $declared_classes_before);

foreach (glob("../Base_app/Pages/*.php") as $filename) {
    require_once $filename;
}

/*
foreach ($new_classes as $table) {
    $base = Database::base();
    $t = new $table;
    if(!$base->table_exists($t->table_name)){
        $base->executeQuery($t->MySQL_CreateQuery());
    }else{
        $base->executeQuery($t->MySQL_UpdateSchema());
    }
}


$base = Database::base();
//$base->executeQuery((new purchaseLine())->MySQL_CreateQuery());
$base->executeQuery((new purchaseHeader())->MySQL_CreateQuery());
if($base->getError()[0] > 0){
    //var_dump((new Item())->MySQL_CreateQuery());
    var_dump($base->getError());
    echo (new purchaseHeader())->MySQL_CreateQuery();
}*/


//initializing base objects
new RoleCenter();


new CountryList();
new CitiesList();
new GLAccountList();
new CustomerList();
new GrpeComptaClientList();
new GrpeComptaMarchesList();
new GrpeComptaProduitsList();
new GrpeComptaFournisseurList();
new Vendors();
new Unites();
new Categories();
new ItemList();
new PurchaseDocumentTypes();
new purchaseOrderList();
//new PurchaseOrderSubForm();

new CustomerCard();
new GLAccountCard();
new GrpeComptaFournisseurCard();
new GrpeComptaClientCard();
new Vendor_Card();
new ItemCard();
new purchaseOrder();




//including fictives data
//include ('Base_configs/fictivData.php');

//Database::base()->executeQuery((new GrpeComptaClient())->MySQL_CreateQuery());


?>