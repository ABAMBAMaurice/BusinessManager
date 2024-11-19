<?php
    class Vendor_Card extends Page{
        public function __construct(){
            parent::__construct(28,'VendorCard', PagesType::Card,'Fiche fournisseur');
            $this->sourceTable = new Vendor();
            $this->setActions();
            $this->layout();
        }

        function setActions(){

            $this->actions(
                name:'NewVendor',
                icon:'account-plus',
                caption:'Nouveau',
                onAction: function(){
                    Page::open(28);
                    $this->rec = new Vendor();
                },
                style: 'primary'
            );
            $this->actions(
                name:'DeleteCuctomer',
                icon:'delete',
                caption:'Supprimer',
                onAction: function(){
                    if(Confirm("Supprimer me client ".$this->rec->No->value)){
                        if($this->rec->Delete()){
                            Page::open(27);
                        }
                    }
                },
                style: 'danger'
            ) ;
            $this->actions(
                name:'CustomerList',
                icon:'file-document',
                caption:'Liste des Fournisseurs',
                onAction: function(){
                    Page::open(27);
                },
                style: 'info'
            ) ;
        }

        function layout(){
            $this->group('Identification', 'Identification',
                new PageField('No', source: $this->rec->No, editable: true, enabled: true, caption: 'N°'),
                new PageField('vendor_Name', source: $this->rec->vendor_Name, editable: true, enabled: true, caption: 'Nom')
            );
            $this->group('Legal_info', 'Fiscalité',
                new PageField('seller_register', source: $this->rec->seller_register, editable: true, enabled: true, caption: 'Registre de commerce'),
                new PageField('tax_code', source: $this->rec->tax_code, editable: true, enabled: true, caption: 'N° fiscal')
            );
            $this->group('Address', 'Adresse',
                new PageField('email', source: $this->rec->email, editable: true, enabled: true, caption: 'E-mail'),
                new PageField('phoneNo', source: $this->rec->phoneNo, editable: true, enabled: true, caption: 'N° de téléphone'),
                new PageField('address', source: $this->rec->address, editable: true, enabled: true, caption: 'Adresse'),
                new PageField('post_code', source: $this->rec->post_code, editable: true, enabled: true, caption: 'Code postal'),
                new PageField('ville_code', source: $this->rec->ville_code, editable: true, enabled: true, caption: 'Code ville'),
                new PageField('pays_code', source: $this->rec->pays_code, editable: true, enabled: true, caption: 'Code pays')

            );

            $this->group('Contact', 'Représentant',
                new PageField('Contact_LastName', source: $this->rec->Contact_LastName, editable: true, enabled: true, caption: 'Prénom contact'),
                new PageField('Contact_Name', source: $this->rec->Contact_Name, editable: true, enabled: true, caption: 'Nom contact'),
                new PageField('Contact_phoneno', source: $this->rec->Contact_phoneno, editable: true, enabled: true, caption: 'N° téléphone contact'),
                new PageField('Conctact_email', source: $this->rec->Conctact_email, editable: true, enabled: true, caption: 'E-mail contact'),
                new PageField('Contact_Adress', source: $this->rec->Contact_Adress, editable: true, enabled: true, caption: 'Adresse contact'),
                new PageField('Contact_postcode', source: $this->rec->Contact_postcode, editable: true, enabled: true, caption: 'Code postal contact'),
            );

            $this->group('Billing', 'Facturation',
                new PageField('grpe_cpta_marche', source: $this->rec->grpe_cpta_marche, editable: true, enabled: true, caption: 'Grpe. Compta. Marché'),
                new PageField('grpe_cpta_fournisseur', source: $this->rec->grpe_cpta_fournisseur, editable: true, enabled: true, caption: 'Grpe. Compta. Fournisseur')
            );
        }
    }
?>
