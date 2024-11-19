<?php

    class GrpeComptaFournisseur extends Table{
        public function __construct()
        {
            parent::__construct(2000007, 'grpecomptafournisseur');

            $this->field(1,'Code', FieldType::text(30), caption: 'Code');
            $this->field(2,'Compte_achat_client', FieldType::text(30), caption: 'Compte Achat client',tableRelation: new GLAccounts());
            $this->field(3,'Compte_rabais_client', FieldType::text(30), caption: 'Compte Rabais client',tableRelation: new GLAccounts());
            $this->field(4,'Compte_remise_client', FieldType::text(30), caption: 'Compte Remise client',tableRelation: new GLAccounts());
            $this->field(5,'Compte_ristourne_client', FieldType::text(30), caption: 'Compte ristourne client',tableRelation: new GLAccounts());


            $this->Keys('Code');
        }
    }

?>
