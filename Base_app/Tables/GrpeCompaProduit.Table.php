<?php
    class GrpeCompaProduit extends Table{
        public function __construct() {
            parent::__construct(2000099, 'grpe_compa_produit');

            $this->field(1,'Code', FieldType::text(30));
            $this->field(2,'Description', FieldType::text(100));


            $this->Keys('Code');
        }
    }
?>
