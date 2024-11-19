<?php
   class GrpeComptaFournisseurCard extends Page
   {
       public function __construct()
       {
           parent::__construct(2007, 'GrpeComptaFournisseur', PagesType::Card, 'Fiche groupe compta fournisseur');
           $this->sourceTable = new GrpeComptaFournisseur();
           $this->setActions();
           $this->layout();

       }

       function setActions(){
           $this->actions(
               name: 'New',
               icon: 'plus',
               caption: 'Nouveau',
               onAction: function(){
                    Page::open(2007);
               },
                style: 'success'
           );

           $this->actions(
               name: 'Del',
               icon: 'minus',
               caption: 'Supprimer',
               onAction: function(){
                    if(Confirm('Voulez vous supprimer '.$this->rec->Code->value.' ?')) {
                        if($this->rec->Delete())
                             Page::open(2006);
                    }
               },
               style: 'danger'
           );

           $this->actions(
               name: 'List',
               icon: 'list',
               caption: 'Liste',
               onAction: function(){
                    Page::open(2006);
               }
           );
       }

       function layout(){
            $this->group('GpeComptaClient', 'Général',
                new PageField('Code',$this->rec->Code, editable: true, visible: true,caption: 'Code'),
                new PageField('Compte_acha_client',$this->rec->Compte_achat_client, editable: true, visible: true,caption: 'Compte vente'),
                new PageField('Compte_rabais_client',$this->rec->Compte_remise_client, editable: true, visible: true,caption: 'Compte rabais'),
                new PageField('Compte_remise_client',$this->rec->Compte_rabais_client, editable: true, visible: true,caption: 'Compte remise'),
                new PageField('Compte_ristourne_client',$this->rec->Compte_ristourne_client, editable: true, visible: true,caption: 'Compte ristourne')
            );
       }
   }


?>
