<?php

    class PurchaseDocumentTypes extends Page {
        public function __construct()
        {
            parent::__construct(99, 'PurchaseDocumentTypes',PagesType::List,'Types document achat'
            );
            $this->sourceTable = new PurchaseDocumentType();
            $this->setAction();
            $this->layout();
        }

        function setAction(){
            $this->actions('New', 'plus', 'Nouveau', function(){
                $u = new PurchaseDocumentType();
                $u->Insert();
            },
            style: 'success');

            $this->actions('DEL', 'minum', 'Delete', function(){
                if(Confirm('Voulez vous supprimer '.$this->rec->Code->value.' ?')) {
                    $this->rec->Delete();
                }
            },
            style: 'danger');
        }

        function layout()
        {
            $this->repeater('PurchaseDocumentTypesList', 'Type document achats',
                new PageField(name:'Code', source:$this->rec->Code, editable: true, enabled: true, caption: 'Code'),
                new PageField(name: 'Description', source: $this->rec->Description, editable: true, enabled: true, caption: 'Description')
            );
        }
    }


?>
