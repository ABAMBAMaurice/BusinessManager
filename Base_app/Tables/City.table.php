<?php
    class City extends Table {
        public function __construct(){
            parent::__construct(2000003,'city');

            $this->field(
                id:1,
                name:'Code',
                type:FieldType::text(30)
            );
            $this->field(
                id:2,
                name:'Name',
                type:FieldType::text(10)
            );
            $this->field(
                id:3,
                name:'pays_code',
                type:FieldType::text(10),
                tableRelation: new Country()
            );
            $this->Keys('Code');

        }
    }

?>
