<?php

class CountryCard extends Page{
    public function __construct(){
        parent::__construct(25,'CountryCard', PagesType::Card, 'Fiche pays');
        $this->sourceTable = new Country();
        $this->setActions();
        $this->layout();
    }


        function setActions(){
        $this->actions(
            name:'Nouveau',
            icon:'account-plus',
            caption:'Nouveau',
            onAction: function(){
                $this->rec = new Country();
                Page::open(25);
            },
            style: 'success'
        );
        $this->actions(
            name:'DeleteCountry',
            icon:'delete',
            caption:'Supprimer',
            onAction: function(){
                $this->rec->Delete();
                Page::open(24);
            },
            style: 'danger'
        ) ;
        $this->actions(
            name:'Country_List',
            icon:'filde-document',
            caption:'Liste des pays',
            onAction: function(){
                Page::open(24);
            },
            style: 'primary'
        ) ;
    }

    function layout()
    {
        $this->group('General', 'Général',
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
                caption: 'Code Iso'
            ),
            new PageField(
                name: 'Name',
                source: $this->rec->Name,
                editable: true,
                visible: true,
                caption: 'Nom'
            )
        );
    }
    public function onOpenPage()
    {
        //Message($this->rec->MySQL_DeleteQuery());
    }
}