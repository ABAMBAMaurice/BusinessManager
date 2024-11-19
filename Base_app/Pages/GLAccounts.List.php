<?php

class GLAccountList extends Page {
    public function __construct(){
        parent::__construct(2000,'GlAccountList', PagesType::List, 'Plan comptable');
        $this->sourceTable = new GLAccounts();
        $this->setActions();
        $this->layout();
        //$this->cardPageID = 2001;
    }

    function setActions(){
        $this->actions(
            name:'New',
            icon:'plus',
            caption:'Nouveau',
            onAction: function(){
                //Page::open(2001);
            },
                style: 'success'

        );
        /*$this->actions(
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
        );*/

    }
    function layout(){
        $this->repeater('CityList','Liste des villes',
            new PageField(
                name: 'Compte',
                source: $this->rec->Compte,
                editable: true,
                enabled: true,
                visible: true,
                caption: 'N° de compte'
            ),
            new PageField(
                name: 'Description',
                source: $this->rec->Description,
                editable: true,
                enabled: true,
                visible: true,
                caption: 'Description'
            ),
            new PageField(
                name: 'Gestion',
                source: $this->rec->Gestion,
                editable: true,
                enabled: true,
                visible: true,
                caption: 'Compte de gestion'
            ),
            new PageField(
                name: 'Imputable',
                source: $this->rec->Imputable,
                editable: true,
                enabled: true,
                visible: true,
                caption: 'Compte imputable'
            )
        );
    }
}
