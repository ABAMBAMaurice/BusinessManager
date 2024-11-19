<?php
    class ItemCard extends Page {
        public function __construct()
        {
            parent::__construct(40, 'Item card', PagesType::Card, 'Fiche article');
            $this->sourceTable= new Item();
            $this->setAction();
            $this->layout();
        }

        function setAction(){

            $this->actions(
                name:'NewItems',
                icon:'account-plus',
                caption:'Nouveau',
                onAction: function(){
                    Page::open(40);
                },
                style: 'primary'
            );
            $this->actions(
                name:'DeleteItem',
                icon:'delete',
                caption:'Supprimer',
                onAction: function(){
                    if(Confirm("Supprimer me client ".$this->rec->No)){
                        if($this->rec->Delete()){
                            Page::open(41);
                        }
                    }
                },
                style: 'danger'
            ) ;
            $this->actions(
                name:'ItemsList',
                icon:'file-document',
                caption:'Liste des articles',
                onAction: function(){
                    Page::open(41);
                },
                style: 'info'
            ) ;
        }

        function layout()
        {
            $this->group('General', 'Général',
                new PageField('No', $this->rec->No, editable: true, caption: 'N°'),
                new PageField('description', $this->rec->description, editable: true, caption: 'Description'),
                new PageField('description2', $this->rec->description2, editable: true, caption: 'Description 2'),
                new PageField('category', $this->rec->category, onValidate: function (){
                    $categ = new Category();
                    if($categ->get($this->rec->category)){
                        $this->Validate('desc_categ', $categ->Description);
                    }
                }, editable: true, caption: 'Code catégorie'),
                new PageField('desc_categ', $this->rec->desc_categ, editable: false, caption: 'Description catégorie'),
            );

            $this->group('Stockage', 'Stockage',
                new PageField('unite', $this->rec->unite, onValidate: function (){
                    $unit = new Unite();
                    if($unit->get($this->rec->unite)){
                        $this->Validate('desc_unite', $unit->Description);
                    }
                }, editable: true, caption: 'Unité'),
                new PageField('desc_unite', $this->rec->desc_unite, editable: false, caption: 'Description unité'),
                new PageField('Stock', $this->rec->Stock, editable: false, caption: 'Stock'),

            );
            $this->group('Settings', 'Parametrages',
                new PageField('GrpeComptaProduit', $this->rec->GrpeComptaProduit, editable: true, caption: 'Groupe compta. produit')
            );
        }
    }
