<?php
class PurchaseDocumentType extends Table {
    public function __construct()
    {
        parent::__construct(99, 'PurchaseDocumentType');

        $this->field(1, 'Code', FieldType::text(30),caption:'N°');
        $this->field(2, 'Description', FieldType::text(50),caption:'Description');

        $this->Keys('Code');
    }
}

?>