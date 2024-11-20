<?php
    class Vendor extends Table{
        public function __construct(){
            parent::__construct(23, 'vendor');

            //Donnéees générales
            $this->field(
                id: 1, name: 'No', type: FieldType::text(30), caption: 'N°'
            );

            $this->field(
                id: 2, name: 'vendor_Name', type: FieldType::text(100), caption: 'Raison sociale'
            );

            //Données du contact le cas échéant

            $this->field(
                id: 3, name: 'Contact_Name', type: FieldType::text(100), caption: 'Nom contact'
            );


            $this->field(
                id: 4, name: 'Contact_LastName', type: FieldType::text(100), caption: 'Prénom contact'
            );

            $this->field(
                id: 5, name: 'Contact_Adress', type: FieldType::text(100), caption: 'Adresse contact'
            );

            $this->field(
                id: 6, name: 'Contact_postcode', type: FieldType::text(100), caption: 'Code postal contact'
            );

            $this->field(
                id: 7, name: 'Contact_phoneno', type: FieldType::text(100), caption: 'N° téléphone contact'
            );

            $this->field(8, 'Conctact_email', FieldType::text(200),
                caption: 'E-mail contact'
            );

            //Données légales et fiscales

            $this->field(9, 'seller_register', FieldType::text(50),
                caption: 'Registre de commerce'
            );

            $this->field(10, 'tax_code', FieldType::text(50),
                caption: 'N° fiscal'
            );

            //Données contacts et adresses de l'entreprise

            $this->field(11, 'email', FieldType::text(200),
                caption: 'E-mail'
            );

            $this->field(12, 'phoneNo', FieldType::text(30),
                caption: 'N° de téléphone'
            );


            $this->field(
                id: 13,
                name: 'pays_code',
                type: FieldType::text(30),
                tableRelation: new Country(),//Table::$_tableCollection['country'],
                editable: false,
                caption: 'Code pays'
            );

            $this->field(14, 'ville_code', FieldType::text(30),
                tableRelation: new City(), caption: 'Code ville'
            );

            $this->field(15, 'post_code', FieldType::text(30),
                caption: 'Code postal'
            );

            $this->field(16, 'address', FieldType::text(200),
                caption: 'Adresse'
            );

            //Données de comptabilisation

            $this->field(17, 'grpe_cpta_marche', FieldType::text(30),
                tableRelation: new GrpeCompaMarche(), caption: 'Grpe. Compta. Marché'
            );

            $this->field(18, 'grpe_cpta_fournisseur', FieldType::text(30),
                tableRelation: new GrpeComptaFournisseur(), caption: 'Grpe. Compta. Fournisseur'
            );

            $this->field(19, 'blocked', FieldType::boolean(),
                caption: 'Bloqué'
            );



            $this->Keys('No');


        }
    }