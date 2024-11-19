<?php

    class GrpeComptaMarchesList extends Page {

        public function __construct() {
            parent::__construct(2002,'GrpeComptaMarches', PagesType::List, 'Groupe compta. marché');
            $this->sourceTable = new GrpeCompaMarche();
            $this->setActions();
            $this->layout();
        }

        function setActions()
        {
            $this->actions(
                name: 'Nouveau',
                icon: 'plus',
                caption: 'Nouveau',
                onAction: function(){
                    $grpeComp = new GrpeCompaMarche();
                    $grpeComp->Insert();
                },
                style: 'success'
            );

            $this->actions(
                name: 'Supprimer',
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
        }

        function layout()
        {
            $this->repeater('ListeGrpeComptaMarches', 'Groupes Compta. Marchés',
                new PageField('Code',$this->rec->Code, caption: 'Code',enabled: true, editable: true),
                new PageField('Description',$this->rec->Description, caption: 'Description',enabled: true, editable: true)
            );
        }
    }

?>
