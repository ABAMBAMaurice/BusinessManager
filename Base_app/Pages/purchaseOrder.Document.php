<?php

    class purchaseOrder extends Page{
        public function __construct()
        {
            parent::__construct('80', 'PurchaseOrder', PagesType::Document,'Commande achat');
            $this->sourceTable = new purchaseHeader();
            $this->_lines = new purchaseLine();
            $this->subPageLink = new purchaseLine();
            $this->pageFieldLink = [
                $this->rec->No,
                $this->rec->Document_type
            ];
            $this->subPageFieldLink = [
                $this->subPageLink->Document_No,
                $this->subPageLink->Document_type
            ];
            $this->setActions();
            $this->layout();
        }


        function setActions(){
            $this->actions(name: 'NewOrder', icon: 'plus', caption: 'Nouvelle commande', onAction: function(){
                Page::open(80);
            }, style: 'success');

            $this->actions(name: 'DelOrder', icon: 'minus', caption: 'Supprimer commande', onAction: function(){
                    if(Confirm("Supprimer la commande ".$this->rec->No." ?")){
                        if($this->rec->Delete()){
                            Page::open(82);
                        }
                    }

            }, style: 'danger');

            $this->actions(name: 'NewLine', icon: 'plus', caption: 'Nouvelle ligne', onAction: function(){
                $this->addNewLine();
            }, style: 'primary');
        }

        function layout()
        {
            $this->group('General', 'Général',
                new PageField('No',$this->rec->No, editable: true, enabled: true, caption: 'N°'),
                new PageField('Document_type',$this->rec->Document_type, editable: false, enabled: false, caption: 'Type de document'),
                new PageField('Order_Date',$this->rec->Order_Date, editable: true, enabled: true, caption: 'Date de commande'),
                new PageField('Release_date',$this->rec->Release_date, editable: true, enabled: true, caption: 'Date d échéance'),
                new PageField('discount', source: $this->rec->discount, editable: true, enabled: true, caption: 'Remise %'),
                new PageField('VAT',$this->rec->VAT, editable: true, enabled: true, caption: 'TVA %'),
                new PageField('customer_No',$this->rec->customer_No, onValidate: function(){
                    $cust = new Customer();
                    if($cust->get($this->rec->customer_No)){
                        $this->Validate("customer_Name", $cust->name);
                    }
                }, editable: true, enabled: true, caption: 'N° client'),
                new PageField('customer_Name',$this->rec->customer_Name, editable: false, enabled: true, caption: 'Nom client'),
            );


            $this->subRepeater('purchLine','Lignes',new purchaseLine(),
                new PageField('Line_No', $this->subPageLink->Line_No,editable: false,enabled: true,caption: 'N° Ligne'),
                new PageField('Document_type', $this->subPageLink->Document_type,editable: false,enabled: true,caption: 'Type document'),
                new PageField('Document_No', $this->subPageLink->Document_No,editable: false,enabled: true,caption: 'N° document'),
                new PageField('Item_No', $this->subPageLink->Item_No, editable: true, enabled: true, caption: 'N° article'),
                new PageField('Item_description', $this->subPageLink->Item_description,editable: true,enabled: true,caption: 'Description'),
                new PageField('Item_description2', $this->subPageLink->Item_description2,editable: true,enabled: true,caption: 'Description 2'),
                new PageField('Qty', $this->subPageLink->Qty,editable: true,enabled: true,caption: 'Quantité'),
                new PageField('Unit_price', $this->subPageLink->Unit_price,editable: true,enabled: true,caption: 'Prix unitaire'),
                new PageField('Amount', $this->subPageLink->Amount,editable: false,enabled: true,caption: 'Montant'),
            );
        }
        
        function setItemDesc(){            
            if($this->subPageLink->Item_No != ''){
                $item = new Item();
                $item->setRange('No', $this->subPageLink->Item_No);
                if($item->FindFirst()){
                    $this->subPageLink->Validate('Item_description', $item->description);
                }
            }
        }

        function setLineAmount(){            
            if($this->subPageLink->Qty != ''){
                $this->subPageLink->Validate('Amount', $this->subPageLink->Qty->value*$this->subPageLink->Unit_price->value);
            }       

            if($this->subPageLink->Unit_price != ''){
                $this->subPageLink->Validate('Amount', $this->subPageLink->Qty->value*$this->subPageLink->Unit_price->value);
            }
        }

        function setDiscount(){
            if($this->subPageLink->Discount != '')
                $this->subPageLink->Validate('Discount_amount',$this->getPercentDiscount($this->subPageLink->Discount->value, $this->subPageLink->Amount->value));
                
        }

        function getPercentDiscount($discountPercent, $lineAmount){
            if($discountPercent < 0)
                Error('Le taux de la remise ne doit pas être négatif');
            
            return $lineAmount * $discountPercent/100;
        }

        function addNewLine(){

            $achatLine = new PurchaseLine();

            $achatLine->Validate('Line_No', $this->getLineNo());
            $achatLine->Validate('Document_No', $this->rec->No);
            $achatLine->Validate('Document_type', 'COMMANDE');
            $achatLine->Insert();

        }

        function getLineNo(){
            $LineNo = 0;

            $Achatline1 = new purchaseLine();
            $Achatline1->setRange('Document_No', $this->rec->No);
            $Achatline1->setRange('Document_type', $this->rec->Document_type);

            if ($Achatline1->FindLast()) {
                $LineNo = $Achatline1->Line_No;
            }

            return $LineNo->value+1;
        }
    }
?>

