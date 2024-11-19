<?php
    class GLAccounts extends Table {
        public function __construct(){
            parent::__construct(2000004,'general_accounts');

            $this->field(
                id:1,
                name:'Compte',
                type:FieldType::text(10)
            );
            $this->field(
                id:2,
                name:'Description',
                type:FieldType::text(100)
            );
            $this->field(
                id:3,
                name:'Gestion',
                type:FieldType::boolean()
            );
            $this->field(
                id:3,
                name:'Imputable',
                type:FieldType::boolean()
            );


            $this->Keys('Compte');

        }
    }

?>
