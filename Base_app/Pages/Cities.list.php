<?php
class CitiesList extends Page{
    public function __construct(){
        parent::__construct(26,'CityListe', PagesType::List, 'Villes');
        $this->sourceTable = new City();
        $this->setActions();
        $this->layout();

    }

    function setActions(){
        $this->actions(
            name:'New',
            icon:'plus',
            caption:'Nouveau',
            onAction: function(){
                $ville = new City();
                $ville->Insert();
            },
            style: "success"

        );
        $this->actions(
            name: 'Delete',
            icon: 'minus',
            caption: 'Supprimer',
            onAction: function(){
                if(Confirm('Voulez vous supprimer '.$this->rec->Code->value.' ?')) {
                    if($this->rec->Delete())
                        Message($this->rec->Code->value.' supprimé');
                }
            },
            style: 'danger',

        );
        $this->actions(
            name:'Pays',
            icon:'search',
            caption:'Liste des pays',
            onAction: function(){
                Page::open(24);
            },
            style: "info"

        );
    }

    function layout(){
        $this->repeater('CityList','Liste des villes',
            new PageField(
                name: 'pays_code',
                source: $this->rec->pays_code,
                onLookUp: function(){},
                editable: true,
                enabled: true,
                visible: true,
                caption: 'Code pays'
            ),
            new PageField(
                name: 'Code',
                source: $this->rec->Code,
                editable: true,
                enabled: true,
                visible: true,
                caption: 'Code'

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
