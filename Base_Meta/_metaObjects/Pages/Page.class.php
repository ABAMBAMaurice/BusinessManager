
<?php

    require('Pages.interface.php');
    require('PageField.class.php');
    require('action.class.php');
    require('groups.class.php');
    require('repeater.class.php');

    class Page implements Pages {
        private $_id;
        private $_name;
        private $_type;
        private $_rec;
        public static $_pageCollection = array();
        private $_fieldsList = array();
        private $_bodyHTML = '';
        private $_actionsList = array();
        private $_groups = array();
        private $_caption='';
        private $_cardPageID = '';
        private $_subPageLink = '';
        private $_subPageFieldLink = '';
        private $_pageFieldLink = '';


        public function __construct($id, $name, $type, $caption = ''){
            $this->_id = $id;
            $this->_name = $name;
            $this->_type = $type;
            $this->_caption = $caption;

            Page::$_pageCollection[$id] = $this;

            $_SESSION['pageCollection'] = Page::$_pageCollection;

        }

        public function group($name, $caption, ...$fields){
            if(isset($this->_groups[$name]))
                Error('Groupe '.$name.' existe déja');
            $nGroup = new group($name, $caption);
            $nGroup->SourceTableId = $this->rec->table_id;
            $nGroup->SourceTableName = $this->rec->table_name;
            $nGroup->SourcePageName = $this->pageName;
            $nGroup->SourcePageId = $this->id;

            foreach ($fields as $field){
                $nGroup->fields($field->_name, $field);
            }
            $this->_groups[$name] = $nGroup;
        }

        public function repeater($name, $caption, ...$fields){
            if(isset($this->_groups[$name]))
                Error('Groupe '.$name.' existe déja');
            $nGroup = new repeater($name, $caption);
            $nGroup->SourceTableId = $this->rec->table_id;
            $nGroup->SourceTableName = $this->rec->table_name;
            $nGroup->SourcePageName = $this->pageName;
            $nGroup->SourcePageId = $this->id;

            foreach ($fields as $field){
                $nGroup->fields($field->_name, $field);
            }
            $this->_groups[$name] = $nGroup;
        }

        public function subRepeater($name, $caption, $record, ...$fields){
            if(isset($this->_groups[$name]))
                Error('Groupe '.$name.' existe déja');
            $nGroup = new SubRepeater($name, $caption, $this, $record);
            $nGroup->SourceTableId = $this->rec->table_id;
            $nGroup->SourceTableName = $this->rec->table_name;
            $nGroup->SourcePageName = $this->pageName;
            $nGroup->SourcePageId = $this->id;

            foreach ($fields as $field){
                $nGroup->fields($field->_name, $field);
            }
            $this->_groups[$name] = $nGroup;
        }

        /**
         * This function is marked for removal 
         */
        /*public function part($name,$source, $caption, $part){
            if(isset($this->_groups[$name]))
                Error('Groupe '.$name.' existe déja');
            $nGroup = new part(name:$name, source: $source, caption: $caption, page:$part);
            $nGroup->SourceTableId = $this->rec->table_id;
            $nGroup->SourceTableName = $this->rec->table_name;
            $nGroup->SourcePageName = $this->pageName;
            $nGroup->SourcePageId = $this->id;

            $this->_groups[$name] = $nGroup;
        }*/

        public function actions($name, $icon=null, $caption=null, $onAction = null, $html='', $style='inverse-dark'){
            if($onAction == null){
                $FctAction = function(){};
            }else{
                $FctAction = $onAction;
            }
            $this->_actionsList[$name] = new Control($name, $icon, $caption, $FctAction, $html, $style);
        }

        public function field($name, $source, $onValidate = null, $onLookUp = null, $editable = true, $enabled = true, $visible = true, $caption = null, $html=''){
            $pgeField =  new PageField(
                name: $name,
                source: $source,
                onValidate: $onValidate,
                onLookUp: $onLookUp,
                editable: $editable,
                enabled: $enabled,
                visible: $visible,
                caption: $caption,
                html: $html
            );

            $this->_fieldsList[$name] = $pgeField;
        }

        public function __set($name, $value){
            switch ($name) {
                case 'sourceTable':
                case 'rec':
                    $this->_rec = $value;
                    break;
                case 'html':
                    $this->_bodyHTML = $value;
                    break;
                case 'editionMode':
                    $this->_editionMode = $value;
                    break;
                case 'cardPageID':
                    $this->_cardPageID = $value;
                    break;
                case 'subPageLink':
                    $this->_subPageLink = $value;
                    break;
                case 'subPageFieldLink':
                    $this->_subPageFieldLink = $value;
                    break;
                case 'pageFieldLink':
                    $this->_pageFieldLink = $value;
                    break;
            }
        }

        public function __get($name){
            switch ($name) {
                case 'rec':
                    return $this->_rec;
                    break;
                case 'pageName':
                    return $this->_name;
                    break;
                case 'type':
                    return $this->_type;
                    break;
                case 'actions':
                    return $this->_actionsList;
                    break;
                case 'id':
                    return $this->_id;
                    break;
                case 'editionMode':
                    return $this->_editionMode;
                    break;
                case 'groups':
                    return $this->_groups;
                    break;
                case 'cardPageID':
                    return $this->_cardPageID;
                    break;
                case 'subPageLink':
                    return $this->_subPageLink;
                    break;
                case 'subPageFieldLink':
                    return $this->_subPageFieldLink;
                    break;
                case 'pageFieldLink':
                    return $this->_pageFieldLink;
                    break;

                default:
                    if(isset($this->_fieldsList[$name])){
                        return $this->_fieldsList[$name];
                    }
                    break;
            }
        }

        public function HTML()
        {
            $h = '100%';
            if($this->_type == PagesType::ListPart)
                $h = '50vh';
            else if ($this->_type == PagesType::Document)
                $h = '100%';

            $bodyHtml = '';
            $titleBar = $this->_caption;
                    $HeadHtml = '
                        <div class="col-12 grid-margin">
                            <div class="card" style="border-radius: 0px; box-shadow: none;">
                                <div class="card-header" style="padding: 15px;">                                
                                    <h6>'.$titleBar. '</h6>
                                </div>
                                <div class="card-body">
                                    <form class="forms-sample" id="formPage'.$this->_id.'">
                                        <div class="row">
                    ';
                                        //actions
                                        $actionsHtml = '                                            
                                                                    
                                                <div style="overflow-x: scroll">
                                                ';
                                                    foreach($this->_actionsList as $action){
                                                        $actionsHtml .= '
                                                        <div class="" style="display: inline-block;padding: 3px;">
                                                            <div>';
                                                            $actionsHtml = $actionsHtml.'<a href="#" class="btn btn-'.$action->style.'" style="border-radius: 0px; font-size:12px;" id="'.$action->name.'"><i class="mdi mdi-'.$action->icon.'"></i> '.$action->caption.'</a>';
                                                        $actionsHtml = $actionsHtml.
                                                        '
                                                                <script>
                                                                    $("#'.$action->name.'").click(function(){
                                                                    ';
                                                                        if($this->_type != PagesType::List && $this->_type != PagesType::ListPart) {
                                                                            $actionsHtml .= '                                                                                
                                                                                submitFormBtn("' . $this->_id . '", "' . $this->_id . '", "' . $action->name . '")
                                                                            ';
                                                                        }else{
                                                                            $actionsHtml .= '                                                                                
                                                                                $repeteur = $("#'.$this->_name.'DataRepeter'.$this->_rec->table_name.'").DataTable();
                                                                                var lineRow = $repeteur.row({ selected: true });
                                                                                
                                                                                // Crée un objet pour stocker les données
                                                                                    let rowData = [];
                                                                                // Parcours chaque cellule et récupère le nom et la valeur
                                                                                    $(lineRow.node()).find("td[data-name]").each(function() {                                                                   
                                                                                        let nom = $(this).data("name");
                                                                                        let value = $(this).text();                                                                                        
                                                                                        rowData.push({"name":nom,"value":value});
                                                                                    });
                                                                                    
                                                                                submitFormList("' . $this->_id . '", "' . $this->_id . '", "' . $action->name . '", rowData)
                                                                            ';
                                                                        }

                                                        $actionsHtml .= '
                                                                    })
                                                                </script>
                                                                
                                                            </div>
                                                        </div>';
                                                    }
                                                    $actionsHtml = $actionsHtml.

                                                '<hr>
                                                </div>
                                            
                                            <div class="card-body" style="height: '.$h.'";">
                                                <div class="row col-12">';
                                                //corps
                                                    foreach($this->_groups as $group){
                                                        $bodyHtml .= $group->HTML();
                                                    }
                                                //corps = '';
                                        //card foot
                                        $FootHtml ='
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';


            return $HeadHtml.$actionsHtml.$bodyHtml.$FootHtml;
        }

        public function onOpenPage()
        {

        }
        public function Validate($field, $value)
        {
            if($this->rec->Validate($field, $value)){
                    echo('<script>
                        $("#' . $field . '").val("' . $value . '");
                    </script>');
                return true;
            }else{
                Error('Erreur lors de la validation des données.');
            }
        }

        public function setValue($field, $value)
        {
            echo('<script>
                        $("#' . $field . '").val("' . $value . '");
                    </script>');
        }

        public static function open($Pageid)
        {
            echo '
                <script>
                    getPage("'.$Pageid.'");
                </script>
            ';
        }
        public static function Record_open($Pageid, $record)
        {
            Page::$_pageCollection[$Pageid]->rec = $record;;
            echo '
                <script>
                    getPage("'.$Pageid.'");
                </script>
            ';
        }

        public function OnClosePage()
        {

        }

        public function newRecord(){
            $this->_rec->Insert();
        }

        public function __toString()
        {
            return $this->HTML();
        }

        function layout(){

        }
        function setActions(){

        }


    }
?>
