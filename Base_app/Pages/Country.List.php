<?php
    class CountryList extends Page{
        public function __construct(){
            parent::__construct(24,'CountriesList', PagesType::List, 'Pays');
            $this->sourceTable = new Country();
            $this->setActions();
            $this->layout();
            //$this->cardPageID = 25;

        }

        function setActions(){
            $this->actions(
                name:'New',
                icon:'note-plus',
                caption:'Nouveau',
                onAction: function(){
                    $pays = new Country();
                    $pays->Insert();
                },
                style: 'success'
            );
            $this->actions(
                name: 'Delete',
                icon: 'minus',
                caption: 'Supprimer',
                onAction: function(){
                    if(Confirm('Voulez vous supprimer '.$this->rec->Code->value.' ? Toutes les villes seront aussi supprimées')) {
                        if($this->rec->Delete())
                            Message($this->rec->Code->value.' supprimé');
                    }
                },
                style: 'danger',

            );
            $this->actions(
                name: 'Cities',
                icon: 'domain',
                caption: 'Villes',
                onAction: function(){
                   Page::open(26);
                },
                style: "info"
            );
        }

        function layout(){
            $this->repeater('countryList','Liste des pays',
                new PageField(
                    name: 'Code',
                    source: $this->rec->Code,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Code'
                ),
                new PageField(
                    name: 'IsoCode',
                    source: $this->rec->IsoCode,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Code iso'
                ),
                new PageField(
                    name: 'Name',
                    source: $this->rec->Name,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Nom'

                ),
            );


        }

        public function onOpenPage()
        {

        }

    }
?>
