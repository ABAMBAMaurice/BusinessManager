<?php
    
    class Categories extends Page {
        public function __construct()
        {
            parent::__construct(31, 'Categories',PagesType::List,'Catégories'
            );
            $this->sourceTable = new Category();
            $this->setAction();
            $this->layout();
        }

        function setAction(){
            $this->actions('New', 'plus', 'Nouveau', function(){
                $u = new Category();
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
            $this->repeater('CategListe', 'Catégories',
                new PageField(name:'Code', source:$this->rec->Code, editable: true, enabled: true, caption: 'Code'),
                new PageField(name: 'Description', source: $this->rec->Description, editable: true, enabled: true, caption: 'Description')
            );
        }
    }


?>
