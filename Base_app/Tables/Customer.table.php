<?php
class Customer extends Table
{
    public function __construct()
    {
        parent::__construct(27, 'customer');


        $this->field(1,'No',FieldType::text(30),
            caption: 'N°'
        );

        $this->field(
            id:2,
            name:'name',
            type:FieldType::text(100),
            caption: 'Raison sociale'
        );

        $this->field(3, 'first_name', FieldType::text(100),
            caption: 'Prénoms'
        );

        $this->field(4, 'last_name', FieldType::text(150),
            caption: 'Nom'
        );

        $this->field(5, 'address', FieldType::text(200),
            caption: 'Adresse'
        );

        $this->field(6, 'post_code', FieldType::text(10),
            caption: 'Code postal'
        );

        $this->field(7, 'seller_register', FieldType::text(50),
            caption: 'Registre de commerce'
        );

        $this->field(8, 'tax_code', FieldType::text(50),
            caption: 'N° fiscal'
        );

        $this->field(9, 'email1', FieldType::text(200),
            caption: 'E-mail 1'
        );

        $this->field(10, 'email2', FieldType::text(200),
            caption: 'E-mail 2'
        );

        $this->field(11, 'telephone_no1', FieldType::text(30)
            ,
            caption: 'Tél 1'
        );

        $this->field(12, 'telephone_no2', FieldType::text(30),
            caption: 'Tel 2'
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
            caption: 'Code ville',tableRelation: new City()
        );

        $this->field(15, 'password', FieldType::text(30),
            caption: 'Mot de passe'
        );

        $this->field(16, 'grpe_cpta_marche', FieldType::text(30),
            tableRelation: new GrpeCompaMarche(), caption: 'Grpe. Compta. Marché'
        );

        $this->field(17, 'grpe_cpta_client', FieldType::text(30),
            tableRelation: new GrpeComptaClient(), caption: 'Grpe. Compta. Client'
        );

        $this->Keys('No');
    }


}

?>