<?php

    class purchaseLine extends table {
        public function __construct()
        {
            parent::__construct('81', 'purchaseline');

            $this->field(1,'Line_No',FieldType::Integer(), editable: false);
            $this->field(2,'Document_No',FieldType::text(30), tableRelation: new purchaseHeader(), editable: false);
            $this->field(3,'Document_type',FieldType::text(30), editable: false);
            $this->field(4,'Item_No',FieldType::text(30), tableRelation: new Item());
            $this->field(5,'Item_description',FieldType::text(150), editable: false);
            $this->field(6,'Item_description2',FieldType::text(150));
            $this->field(7,'Unit_price',FieldType::decimal());
            $this->field(8,'Qty',FieldType::decimal());
            $this->field(9,'Amount',FieldType::decimal(), editable: false);
            $this->field(10,'Discount',FieldType::decimal());
            $this->field(11,'Discount_amount',FieldType::decimal(), editable: false);
            $this->field(12,'VAT',FieldType::decimal());
            $this->field(13,'VAT_amount',FieldType::decimal(), editable: false);

            $this->Keys('Line_No', 'Document_No', 'Document_type');

        }

    }



?>
