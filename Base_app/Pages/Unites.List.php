<?php

    class Unites extends Page {
        public function __construct()
        {
            parent::__construct(30, 'Unites',PagesType::List,'Unités'
            );
            $this->sourceTable = new Unite();
            $this->setAction();
            $this->layout();
        }

        function setAction(){
            $this->actions('New', 'plus', 'Nouveau', function(){
                $u = new Unite();
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
            $this->repeater('UnitListe', 'Unités',
                new PageField(name:'Code', source:$this->rec->Code, editable: true, enabled: true, caption: 'Code'),
                new PageField(name: 'Description', source: $this->rec->Description, editable: true, enabled: true, caption: 'Description')
            );
        }
    }


?>
