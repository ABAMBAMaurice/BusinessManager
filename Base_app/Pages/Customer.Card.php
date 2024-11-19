<?php
    class CustomerCard extends Page{
        public function __construct(){
            parent::__construct(22,'CustomerCard', PagesType::Card, 'Fiche client');
            $this->sourceTable = new Customer();
            $this->setActions();
            $this->layout();
        }


         function setActions(){
            $this->actions(
                name:'NewCustomer',
                icon:'account-plus',
                caption:'Nouveau',
                onAction: function(){
                    Page::open(22);
                    $this->rec = new Customer();
                },
                style: 'success'
                //html: '<a class="btn btn-secondary"><i class="mdi mdi-account-plus"></i> Nouveau</a>'
            );
            $this->actions(
                name:'DeleteCuctomer',
                icon:'delete',
                caption:'Supprimer',
                onAction: function(){
                    if(Confirm("Supprimer me client ".$this->rec->No->value)){
                        if($this->rec->Delete()){
                            Page::open(23);
                        }
                    }
                },
                style: 'danger'
                //html: '<a class="btn btn-danger"><i class="mdi mdi-delete"></i> Supprimer</a>'
            ) ;
            $this->actions(
                name:'CustomerList',
                icon:'file-document',
                caption:'Liste des clients',
                onAction: function(){
                    Page::open(23);
                }
               // html: '<a class="btn btn-inverse-dark"><i class="mdi mdi-file-documente"></i> Céer devis</a>'
            ) ;
        }

        function layout(){
            $this->group('General','Général',
                new PageField(
                    name: 'No',
                    source: $this->rec->No,
                    editable: true,
                    enabled: true,
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
                    name: 'seller_register',
                    source: $this->rec->seller_register,
                    visible: true,
                    caption: 'Régistre de commerce'
                ),
                new PageField(
                    name: 'tax_code',
                    source: $this->rec->tax_code,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'N° Fiscale'
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
                )
            );

            $this->group('Contact', 'Contact',
                new PageField(
                    name:'first_name',
                    source:$this->rec->first_name,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Prénom'
                ),
                new PageField(
                    name:'last_name',
                    source:$this->rec->last_name,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Nom'
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
                    name:'ville_code',
                    source:$this->rec->ville_code,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'ville'
                ),
                new PageField(
                    name:'pays_code',
                    source:$this->rec->pays_code,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'pays'
                ),
                new PageField(
                    name:'telephone_no2',
                    source:$this->rec->telephone_no2,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'N° de téléphone'
                ),
                new PageField(
                    name:'email2',
                    source:$this->rec->email2,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'E-mail'
                ),
            );

            $this->group('Settings', 'Paramétrages',
                new PageField(
                    name:'password',
                    source: $this->rec->password,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Mot de passe'

                ),
                new PageField(
                    name:'grpe_cpta_marche',
                    source: $this->rec->grpe_cpta_marche,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Groupe compta. Marché'
                ),
                new PageField(
                    name:'grpe_cpta_client',
                    source: $this->rec->grpe_cpta_client,
                    editable: true,
                    enabled: true,
                    visible: true,
                    caption: 'Groupe compta. Client'
                ),

            );
        }

        public function onOpenPage()
        {
           // Message($this->rec->MySQL_InsertQuery());
        }
    }
?>
