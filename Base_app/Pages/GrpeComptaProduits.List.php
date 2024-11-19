<?php

    class GrpeComptaProduitsList extends Page {

        public function __construct() {
            parent::__construct(2099,'GrpeComptaProduits', PagesType::List, 'Groupe compta. produits');
            $this->sourceTable = new GrpeCompaProduit();
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
                    $grpeComp = new GrpeCompaProduit();
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
            $this->repeater('ListeGrpeComptaProduits', 'Groupes Compta. Produits',
                new PageField('Code',$this->rec->Code, caption: 'Code',enabled: true, editable: true),
                new PageField('Description',$this->rec->Description, caption: 'Description',enabled: true, editable: true)
            );
        }
    }

?>
