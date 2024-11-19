<?php
    class Budget extends table
    {
        public function __construct(){
            parent::__construct(2000007, "budget");

            $this->field(1,'Code', FieldType::text(30));
            $this->field(2,'Description', FieldType::text(100));
            $this->field(4,'Date_debut', FieldType::date());
            $this->field(5,'Date_fin', FieldType::date());

            $this->Keys('Code');
        }
    }

?>


