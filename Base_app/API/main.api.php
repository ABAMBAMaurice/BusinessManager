<?php
ini_set('memory_limit', -1);
session_start();

// Actions request receiver
if (isset($_POST['PageActionName']) && isset($_POST['PageID'])) {

    $recordData = array();
    if(isset($_POST['record'])) {
        $recordData = $_POST['record'];
        $_SESSION['record'] = $recordData;
        $_SESSION['PageActionName'] = $_POST['PageActionName'];
    }else{
        if(isset($_SESSION['record'])) {
            if($_SESSION['PageActionName'] == $_POST['PageActionName']){
                $recordData = $_SESSION['record'];
            }
            if(session_status() === PHP_SESSION_ACTIVE)
                session_destroy();
        }
    }

    if (isset(Page::$_pageCollection[$_POST['PageID']])) {
        foreach ($recordData as $Rdata) {
            if (!Page::$_pageCollection[$_POST['PageID']]->Validate($Rdata['name'], $Rdata['value'])) {
                Error('Une erreur est survenue');
            }
        }
        if (isset(Page::$_pageCollection[$_POST['PageID']]->actions[$_POST['PageActionName']])) {
            Page::$_pageCollection[$_POST['PageID']]->actions[$_POST['PageActionName']]->onAction();
            if(!isset(getallheaders()['updatable']))
                header('updatable: true');
        } else {
            Error("Mauvaise requête!");
        }
    } else {
        Error("404 Page non trouvée");
    }
}

//reception des champs
if (isset($_POST['PageField']) && isset($_POST['tableId'])
    && isset($_POST['tableName']) && isset($_POST['groupeName'])
    && isset($_POST['pageFieldname']) && isset($_POST['groupeName'])
) {
    if(isset(Page::$_pageCollection[$_POST['page']])) {
        if (isset(Table::$_tableCollection[$_POST['tableName']])) {
            if(isset(Page::$_pageCollection[$_POST['page']]->groups[$_POST['groupeName']])) {

                if(isset(Page::$_pageCollection[$_POST['page']]->groups[$_POST['groupeName']]->fields[$_POST['pageFieldname']])) {

                    $recordData = array();
                    if(isset($_POST['record'])) {
                        $recordData = $_POST['record'];
                        $_SESSION['record'] = $recordData;
                        $_SESSION['pageFieldname'] = $_POST['pageFieldname'];
                    }else{
                        if(isset($_SESSION['record'])) {
                            if($_SESSION['pageFieldname'] == $_POST['pageFieldname']){
                                $recordData = $_SESSION['record'];
                            }
                            if(session_status() === PHP_SESSION_ACTIVE)
                                session_destroy();
                        }
                    }


                    Page::$_pageCollection[$_POST['page']]->rec->reset();{
                    foreach ($recordData as $Rdata)
                        if(!Page::$_pageCollection[$_POST['page']]->Validate($Rdata['name'], $Rdata['value'])){
                            Error('Une erreur est survenue');
                        }
                    }
                    Page::$_pageCollection[$_POST['page']]->groups[$_POST['groupeName']]->fields[$_POST['pageFieldname']]->onValidate();
                    if(Page::$_pageCollection[$_POST['page']]->rec->AllKeysGiven()) {
                        if (Page::$_pageCollection[$_POST['page']]->rec->Exists()) {
                            Page::$_pageCollection[$_POST['page']]->rec->Modify();
                        } else {
                            Page::$_pageCollection[$_POST['page']]->rec->Insert();
                        }
                    }
                }else {
                    Error('Champ <b>'.$_POST['pageFieldname'].'</b> incorrect');
                }
            } else {
                Error('Groupe <b>'.$_POST['groupeName'].'</b> incorrect!');
            }
        } else {
            Error("La table <b>" . $_POST['tableName'] . "</b> n'existe pas");
        }
    }else {
            Error("La page <b>" . $_POST['page'] . "</b> n'existe pas");
    }
}



//reception des Subchamps
if (isset($_POST['SubPageField']) && isset($_POST['SubtableId'])
    && isset($_POST['SubtableName']) && isset($_POST['SubgroupeName'])
    && isset($_POST['SubpageFieldname']) && isset($_POST['SubgroupeName'])
) {
    if(session_status() === PHP_SESSION_ACTIVE)
        session_destroy();

    if(isset(Page::$_pageCollection[$_POST['page']])) {
        if (isset(Table::$_tableCollection[$_POST['SubtableName']])) {
            if(isset(Page::$_pageCollection[$_POST['page']]->groups[$_POST['SubgroupeName']])) {
                if(isset(Page::$_pageCollection[$_POST['page']]->groups[$_POST['SubgroupeName']]->fields[$_POST['SubpageFieldname']])) {
                    $recordData = $_POST['record'];
                    Page::$_pageCollection[$_POST['page']]->subPageLink->reset();
                        foreach ($recordData as $Rdata){
                            if(!Page::$_pageCollection[$_POST['page']]->subPageLink->Validate($Rdata['name'], $Rdata['value'])){
                                Error('Une erreur est survenue');
                            }
                        }

                    Page::$_pageCollection[$_POST['page']]->groups[$_POST['SubgroupeName']]->fields[$_POST['SubpageFieldname']]->onValidate();
                    if(Page::$_pageCollection[$_POST['page']]->subPageLink->AllKeysGiven()) {
                        if (Page::$_pageCollection[$_POST['page']]->subPageLink->Exists()) {
                            Page::$_pageCollection[$_POST['page']]->subPageLink->Modify();
                        } else {
                            Page::$_pageCollection[$_POST['page']]->subPageLink->Insert();
                        }
                    }

                    $rcrd = Page::$_pageCollection[$_POST['page']]->rec;
                    $rcrd->reset();
                        $i = 0;
                    foreach(Page::$_pageCollection[$_POST['page']]->pageFieldLink as $link){
                        $rcrd->setRange($link->_name, Page::$_pageCollection[$_POST['page']]->subPageLink->{Page::$_pageCollection[$_POST['page']]->subPageFieldLink[$i]->_name});
                        $i++;
                    }
                    if($rcrd->FindFirst()) {
                        foreach ($rcrd->_fields as $field) {
                           Page::$_pageCollection[$_POST['page']]->setValue($field->_name, $rcrd->{$field->_name});
                        }
                    }else{
                        Error("Aucun enregistrement de type ".$rcrd->table_name." n'a été trouvé pour les filtres définis");
                    }

                }else {
                    Error('Champ <b>'.$_POST['SubpageFieldname'].'</b> incorrect');
                }
            } else {
                Error('Groupe <b>'.$_POST['SubgroupeName'].'</b> incorrect!');
            }
        } else {
            Error("La table <b>" . $_POST['SubtableName'] . "</b> n'existe pas");
        }
    }else {
        Error("La page <b>" . $_POST['page'] . "</b> n'existe pas");
    }
}







//Réception cardPage From repeater des repeaters
if (isset($_POST['RepeaterSelectedRecordID'])) {
    if(session_status() === PHP_SESSION_ACTIVE)
        session_destroy();

    header('updatable: true');
    Page::$_pageCollection[$_POST['cardPage']]->rec->loadTable();
    $PageRec = Table::$_records[Page::$_pageCollection[$_POST['cardPage']]->rec->table_id][$_POST['RepeaterSelectedRecordID']];
    foreach ($PageRec->_fields as $field) {
        Page::$_pageCollection[$_POST['cardPage']]->Validate($field->_name, $field->_value);
    }
}

?>
