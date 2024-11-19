<?php
class RoleCenter extends Page
{
    public function __construct()
    {
        parent::__construct(1, 'RoleCenter', PagesType::RoleCenter, 'Accueil');
        //$this->sourceTable = new Country();
        $this->setActions();
        $this->layout();
    }


        function setActions(){
            $this->actions(
                name: 'CustListBtn',
                icon: 'list-ol',
                caption: 'Clients',
                onAction: function(){
                    Page::open(23);
                },

            );
            $this->actions(
                name:'CountryListBtn',
                icon:'list-ul',
                caption:'Pays',
                onAction: function(){
                    Page::open(24);
                },

            );
            $this->actions(
                name: 'CitiesListBtn',
                icon: 'list-ol',
                caption: 'Villes',
                onAction: function(){
                    Page::open(26);
                },
            );
            $this->actions(
                name: 'VendorListBtn',
                icon: 'list-ol',
                caption: 'Fournisseurs',
                onAction: function(){
                   Page::open(27);
                },

            );
            $this->actions(
                name: 'PlanComptable',
                icon: 'list-ol',
                caption: 'Plan comptable',
                onAction: function(){
                   Page::open(2000);
                },

            );
            $this->actions(
                name: 'GrpeComptaMarche',
                icon: 'list-ol',
                caption: 'Grpe compta. marché',
                onAction: function(){
                   Page::open(2002);
                },

            );
            $this->actions(
                name: 'GrpeComptaProduit',
                icon: 'list-ol',
                caption: 'Grpe compta. produit',
                onAction: function(){
                   Page::open(2099);
                },

            );
            $this->actions(
                name: 'GrpeComptaClient',
                icon: 'list-ol',
                caption: 'Grpe compta. client',
                onAction: function(){
                   Page::open(2004);
                },

            );
            $this->actions(
                name: 'GrpeComptaFournisseur',
                icon: 'list-ol',
                caption: 'Grpe compta. fournisseur',
                onAction: function(){
                   Page::open(2006);
                },

            );
            $this->actions(
                name: 'UnitsList',
                icon: 'list-ol',
                caption: 'Unites',
                onAction: function(){
                   Page::open(30);
                },

            );
            $this->actions(
                name: 'CategList',
                icon: 'list-ol',
                caption: 'Catégories',
                onAction: function(){
                   Page::open(31);
                },

            );
            $this->actions(
                name: 'ItemList',
                icon: 'list-ol',
                caption: 'Articles',
                onAction: function(){
                   Page::open(41);
                },
            );
            $this->actions(
                name: 'PurchaseOrderList',
                icon: 'list-ol',
                caption: 'Commande achats',
                onAction: function(){
                   Page::open(82);
                },
            );
            $this->actions(
                name: 'PurchaseDocumentTypes',
                icon: 'list-ol',
                caption: 'Types document achat',
                onAction: function(){
                   Page::open(99);
                },
            );
        }

        function layout(){

        }
}