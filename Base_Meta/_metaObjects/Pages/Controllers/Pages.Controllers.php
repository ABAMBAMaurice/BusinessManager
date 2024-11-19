<?php
    session_start();

    require('../../Tables/Field/FieldType.enum.php');
    require('../../Tables/Table.class.php');
    require('../../Pages/Pagetype.enum.php');
    require('../../Controls/Control.class.php');
    require('../../Pages/Page.class.php');


    if(isset($_POST['PageField'])){
        if(isset(Table::$_records[$_POST['tableId']]))
            $record = Table::$_records[$_POST['tableId']];
        else{
            if(isset(Table::$_tableCollection[$_POST['tableName']]))
                $record = Table::$_tableCollection[$_POST['tableName']];
            else
                $record = null;
        }
         var_dump(Table::$_tableCollection);
    }

?>
