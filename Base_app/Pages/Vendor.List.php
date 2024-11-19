<?php

    class Vendors extends Page{
        public function __construct(){
            parent::__construct(27, 'Vendors', PagesType::List,'Fournisseurs');
            $this->sourceTable = new Vendor();
            $this->setActions();
            $this->layout();

            $this->cardPageID = 28;
        }

        function setActions(){
            $this->actions(
                name:'New',
                icon:'note-plus',
                caption:'Nouveau',
                onAction: function(){
                    Page::open(28);
                },
                style: 'primary'
            );
        }

        function layout()
        {
            $this->repeater('VendorsRepeater', 'Liste des fournisseurs',
                new PageField(
                    name: 'No',
                    source: $this->rec->No,
                    editable: false,
                    enabled: false,
                    visible: true,
                    caption: 'N°'
                ),
                new PageField(
                    name: 'vendor_Name',
                    source: $this->rec->vendor_Name,
                    editable: false,
                    enabled: false,
                    visible: true,
                    caption: 'Nom'
                ),
                new PageField(
                    name: 'email',
                    source: $this->rec->email,
                    editable: false,
                    enabled: false,
                    visible: true,
                    caption: 'E-mail'
                ),
                new PageField(
                    name: 'Address',
                    source: $this->rec->address,
                    editable: false,
                    enabled: false,
                    visible: true,
                    caption: 'Adresse'
                ),
                new PageField(
                    name: 'post_code',
                    source: $this->rec->post_code,
                    editable: false,
                    enabled: false,
                    visible: true,
                    caption: 'Code postal'
                ),
                new PageField(
                    name: 'phono',
                    source: $this->rec->phoneNo,
                    editable: false,
                    enabled: false,
                    visible: true,
                    caption: 'N° de téléphone'
                )
            );
        }
    }
