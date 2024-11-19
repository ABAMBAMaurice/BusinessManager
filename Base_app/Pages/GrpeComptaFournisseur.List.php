<?php
   class GrpeComptaFournisseurList extends Page
   {
       public function __construct()
       {
           parent::__construct(2006, 'GrpeComptaFournisseur', PagesType::List, 'Groupe compta. fournisseur');
           $this->sourceTable = new GrpeComptaFournisseur();
           $this->setActions();
           $this->layout();
           $this->cardPageID = 2007;
       }

       function setActions(){
           $this->actions(
               name: 'New',
               icon:'plus',
               caption: 'Nouveau',
               onAction: function(){
                    Page::open(2007);
               },
                style: 'success'
           );
       }

       function layout(){
            $this->repeater('GpeComptaFournisseur', 'Liste',
                new PageField('Code',$this->rec->Code, editable: true, enabled: true, visible: true,caption: 'Code'),
                new PageField('Compte_achat_client',$this->rec->Compte_achat_client, editable: true, enabled: true, visible: true,caption: 'Compte achat'),
                new PageField('Compte_rabais_client',$this->rec->Compte_remise_client, editable: true, enabled: true, visible: true,caption: 'Compte rabais'),
                new PageField('Compte_remise_client',$this->rec->Compte_rabais_client, editable: true, enabled: true, visible: true,caption: 'Compte remise'),
                new PageField('Compte_ristourne_client',$this->rec->Compte_ristourne_client, editable: true, enabled: true, visible: true,caption: 'Compte ristourne')
            );
       }
   }


?>
