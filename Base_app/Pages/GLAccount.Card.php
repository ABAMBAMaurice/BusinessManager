<?php

class GLAccountCard extends Page {
    public function __construct(){
        parent::__construct(2001,'GlAccountList', PagesType::Card, 'Fiche compte');
        $this->sourceTable = new GLAccounts();
        $this->setActions();
        $this->layout();
    }

    function setActions(){
        $this->actions(
            name:'New',
            icon:'plus',
            caption:'Nouveau',
            onAction: function(){
                Page::open(2001);
            },
                style: 'success'

        );
        $this->actions(
            name: 'Delete',
            icon: 'minus',
            caption: 'Supprimer',
            onAction: function(){
                if(Confirm('Voulez vous supprimer '.$this->rec->Compte->value.' ?')) {
                    if($this->rec->Delete()){
                        Page::open(2000);
                    }
                }
            },
            style: 'danger',
        );
;
        $this->actions(
            name: 'Liste',
            icon: 'list',
            caption: 'Liste des comptes',
            onAction: function(){
                Page::open(2000);
            },
            style: 'primary',
        );

    }
    function layout(){
        $this->group('GLAccountListe','Plan comptable',
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
