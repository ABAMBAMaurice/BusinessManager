<?php

    class purchaseHeader extends table {

        public function __construct()
        {
            parent::__construct('80', 'purchaseheader');

            $this->field(1,'No',FieldType::text(30));
            $this->field(2,'Document_type',FieldType::text(30), tableRelation: new PurchaseDocumentType());
            $this->field(3,'Order_Date',FieldType::date());
            $this->field(4,'Release_date',FieldType::date());
            $this->field(5,'discount',FieldType::decimal());
            $this->field(6,'VAT',FieldType::decimal());
            $this->field(7,'customer_No',FieldType::text(30), tableRelation: new Customer());
            $this->field(8,'customer_Name',FieldType::text(150), editable: false);

            $this->Keys('No', 'Document_type');

        }

    }



?>
