<?php

    class purchaseOrderList extends Page{
        public function __construct()
        {
            parent::__construct('82', 'PurchaseOrderList', PagesType::List,'Liste commande achat');
            $this->sourceTable = new purchaseHeader();
            $this->setActions();
            $this->layout();
            $this->cardPageID = 80;
        }


        function setActions(){
            $this->actions(name: 'NewOrder', icon: 'plus', caption: 'Nouvelle commande', onAction: function(){
                Page::open(80);
            }, style: 'success');
        }

        function layout()
        {
            $this->repeater('General', 'Général',
                new PageField('No',$this->rec->No, editable: false, enabled: true, caption: 'N°'),
                new PageField('Document_type',$this->rec->Document_type, editable: false, enabled: true,caption: 'Type de document'),
                new PageField('Order_Date',$this->rec->Order_Date, editable: false, enabled: true,caption: 'Date de commande'),
                new PageField('Release_date',$this->rec->Release_date, editable: false, enabled: true,caption: 'Date d échéance'),
                new PageField('discount',$this->rec->discount, editable: false, enabled: true,caption: 'Remise %'),
                new PageField('VAT',$this->rec->VAT, editable: false, enabled: true,caption: 'TVA %'),
                new PageField('customer_No',$this->rec->customer_No, editable: false, enabled: true,caption: 'N° client'),
                new PageField('customer_Name',$this->rec->customer_Name, editable: false, enabled: true,caption: 'Nom client'),
            );
        }

        function onOpenPage()
        {
            $this->rec->setRange('Document_type', 'COMMANDE');
        }
    }

?>
