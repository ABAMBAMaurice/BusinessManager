<?php
    class CustomerList extends Page{
        public function __construct(){
            parent::__construct(23,'CustomerList', PagesType::List, 'Clients');
            $this->sourceTable = new Customer();
            $this->setActions();
            $this->layout();
            $this->cardPageID = 22;
        }

         function setActions(){
            $this->actions(
                name:'New',
                icon:'account-plus',
                caption:'Nouveau',
                onAction: function(){
                    Page::open(22);
                },
                style: 'success'
            );
        }

        function layout(){
            $this->repeater('clientList','Liste des clients',
                    new PageField(
                        name: 'No',
                        source: $this->rec->No,
                        editable: false,
                        enabled: false,
                        visible: true,
                        caption: 'N°'
                    ),
                    new PageField(
                        name: 'name',
                        source: $this->rec->name,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'Nom'
                    ),
                    new PageField(
                        name: 'email1',
                        source: $this->rec->email1,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'E-mail'

                    ),
                    new PageField(
                        name: 'telephone_no1',
                        source: $this->rec->telephone_no1,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'N° de téléphone'
                    ),
                    new PageField(
                        name:'address',
                        source:$this->rec->address,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'Adresse'
                    ),
                    new PageField(
                        name:'post_code',
                        source:$this->rec->post_code,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'Code postal'
                    ),
                    new PageField(
                        name:'ville',
                        source:$this->rec->ville_code,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'ville'
                    ),
                    new PageField(
                        name:'pays',
                        source:$this->rec->pays_code,
                        editable: true,
                        enabled: true,
                        visible: true,
                        caption: 'pays'
                    )
            );


        }

        public function onOpenPage()
        {
        }

    }
?>
