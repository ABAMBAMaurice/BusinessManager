<?php
class Category extends Table {
    public function __construct()
    {
        parent::__construct(32, 'category');

        $this->field(1, 'Code', FieldType::text(30),caption:'N°');
        $this->field(2, 'Description', FieldType::text(50)/*, onValidate: function(){
            Message('test');
        }*/, caption: 'Description');

        $this->Keys('Code');
    }
}

?>