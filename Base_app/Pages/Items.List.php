<?php


    class ItemList extends Page
    {
        public function __construct()
        {
            parent::__construct(41, 'Item list', PagesType::List, 'Liste articles');
            $this->sourceTable = new Item();
            $this->setAction();
            $this->layout();
            $this->cardPageID = 40;
        }


        function setAction(){

            $this->actions(
                name:'NewItems',
                icon:'account-plus',
                caption:'Nouveau',
                onAction: function(){
                    Page::open(40);
                    $this->rec = new Item();
                },
                style: 'primary'
            );
        }


        function layout()
        {
            $this->repeater('ListeItems', 'Liste articles',
                new PageField('No', $this->rec->No, caption: 'N°'),
                new PageField('Description', $this->rec->description),
                new PageField(name: 'desc_categ', source: $this->rec->desc_categ, caption: 'description catégorie'),
                new PageField(name: 'desc_unite', source: $this->rec->desc_unite, caption: 'Description unite'),
                new PageField('Stock', $this->rec->Stock, caption: 'Stock'),
            );
        }

    }


?>
