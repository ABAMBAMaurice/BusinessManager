<?php 

    require('Table.interface.php');
    require('Field/Field.class.php');
    
    class Table implements Tables{
        private $_id;
        private $_name;
        private $_fields = array();
        private $_recordSet = array();
        private $_keys = array();
        private $_current_keys = "";
        public static $_records = array();

        public static $_tableCollection = array();
        
        public function __construct($id, $name){
            $this->_id = $id;
            $this->_name = $name;

            //System tables field
            $this->field(2000000,'created_at', FieldType::datetime());
            $this->field(2000001,'modified_at', FieldType::datetime());
            $this->field(2000003,'deleted_at', FieldType::datetime());
            $this->field(9999999,'Id_slug', FieldType::text(128));

            if(!isset(Table::$_records[$this->_id])){
                Table::$_records[$this->_id] = array();
            }
            if(!isset(Table::$_tableCollection[$name])){
                Table::$_tableCollection[$name] = array();
            }


            Table::$_tableCollection[$name] = $this;
            $_SESSION['tableCollection'] = Table::$_tableCollection;

        }
        
        public function field($id, $name, $type, $tableRelation = null, $editable = true, $enabled = true, $onValidate = null, $onLookup = null, $caption = null){
            if(!isset($this->_fields[$name])){
                $fld = new Field($id, $name, $type, $tableRelation, $editable, $enabled, $onValidate, $onLookup, $caption);
                $this->_fields[$name] = $fld;
                return $this->_fields[$name];
            }else{
                Error('The field '.$name.' already exists in the table '. $this->_name);
            }
        }
        
        public function __get($name){

                switch($name){
                    case 'table_id':
                       return $this->_id;
                        break;
                    case 'table_name':
                        return $this->_name;
                        break;
                    case '_fields':
                        return $this->_fields;
                        break;
                    case 'recordSet':
                        return $this->_recordSet;
                        break;
                    case 'keysList':
                        return $this->_keys;
                        break;
                    case 'keys':
                        $stringKey = '';
                        //$this->testKeys();
                        foreach ($this->_keys as $key) {
                            $stringKey = $stringKey . $key->_value;
                        }
                        return $stringKey;
                        break;
                    default:
                        if(isset($this->_fields[$name])){
                            return $this->_fields[$name];
                        }
                        break;
                }

        }
        
        public function __set($name, $value){
            if(isset($this->_fields[$name])){
                $this->_fields[$name]->_value = $value;
            }else{
                switch($name){
                    case 'id':
                        $this->_id = $value;
                        break;
                    case 'table_name':
                        $this->_name = $value;
                        break;
                }
            }
        }
        
        public function Validate($field, $value){
            if(isset($this->_fields[$field])) {
                $this->_fields[$field]->_value = $value;
                $this->_fields[$field]->onValidate();
                return true;
            }else{
                Error('Erreur de Validation. Champs "'.$field.'" inconnu');
            }
        }
        
        public function get(...$keys){
            if(count($keys) == count($this->_keys)){
                $stringKey = '';
                foreach($keys as $key){
                    $stringKey = $stringKey.$key;
                }
                if(isset(Table::$_records[$this->_id][$stringKey])) {
                    $this->copyRecord(Table::$_records[$this->_id][$stringKey]);
                    return Table::$_records[$this->_id][$stringKey];
                }else
                    return false;
            }else{
                Error('Nombre de clé incorrect. Vous devirez avoir "'. count($this->_keys).'" clé(s).');
            }
        }
        
        public function setRange($field, $value){
            $this->loadTable();
            if(empty($this->_recordSet)) {
                $records = Table::$_records[$this->_id];
                $this->_recordSet = array();

                foreach ($records as $record) {
                    if ($record->_fields[$field]->_value == $value)
                        array_push($this->_recordSet, $record);
                }
            }else{
                $records = $this->_recordSet;
                $this->_recordSet = array();
                foreach ($records as $record) {
                    if ($record->_fields[$field]->_value == $value)
                        array_push($this->_recordSet, $record);
                }
            }
        }

        public function Find(){
            $this->loadTable();
            $stringKey = '';
            if(!empty($this->_keys)) {
                $this->testKeys();

                foreach ($this->_keys as $key) {
                    $stringKey = $stringKey . $key->_value;
                }

                if(isset(Table::$_records[$this->_id][$stringKey])){
                        $this->copyRecord(Table::$_records[$this->_id][$stringKey]);
                    return Table::$_records[$this->_id][$stringKey];
                }else
                    return false;
            }else
                return false;

        }

        public function Exists(){
            $this->loadTable();

            $stringKey = '';
            if(!empty($this->_keys)) {

                $this->testKeys();

                foreach ($this->_keys as $key) {
                    $stringKey = $stringKey . $key->_value;
                }
                return isset(Table::$_records[$this->_id][$stringKey]) ? true : false;
            }else
                return false;

        }
        
        public function FindSet(){
            if(!empty($this->_recordSet)) {
                return $this->_recordSet;
            }
            else return false;
        }
        
        public function FindFirst(){
            if(!empty($this->_recordSet)) {
                $this->copyRecord($this->_recordSet[0]);
                return $this;
            } else
                return false;
        }
        
        public function FindLast(){

            if(!empty($this->_recordSet)){
                $recordSet  = $this->_recordSet;
                $this->copyRecord(end($recordSet));
                $this->_recordSet = $recordSet;
                return $this;
            } else
                return false ;
        }
        public function FindAll()
        {
            $this->loadTable();
            if(!empty(Table::$_records[$this->_id])) {
                $this->_recordSet = Table::$_records[$this->_id];
                return true;
            }
            else
                return false;
        }
        
        public function Insert($trigger=true){
            $stringKey = md5(uniqid(rand(), true));
            if(!empty($this->_keys)){
                /*$this->testKeys();*/

                foreach($this->_keys as $key){
                    $stringKey = $stringKey.$key->_value;
                }

                if($trigger == true){
                    $this->onInsert();
                }
                if(!isset(Table::$_records[$this->_id][$stringKey])){
                    $this->Validate("created_at",date('Y-m-d H:m:s'));
                    $this->Validate("modified_at",date('Y-m-d H:m:s'));
                    $this->Validate("Id_slug",$stringKey);
                    Table::$_records[$this->_id][$stringKey] = $this;
                    $_SESSION['records'] = Table::$_records;
                    $Insert = Database::base();
                    $Insert->executeQuery($this->MySQL_InsertQuery());
                    if($Insert->getError()[1] != 0)
                        Error("Erreur SQL N°: ".$Insert->getError()[1]."<br>Message: ".$Insert->getError()[2]);
                    else
                        return true;
                }else{
                    Error('Duplicata pour la clé primaire dans la table "'. $this->_name.'"');
                }
            }else{
                Error('Vous devriez définir au moins une clé');
            }
        }

        public function Keys(...$names){

            foreach ($names as $name){
                array_push($this->_keys, $this->_fields[$name]);
            }
        }
        
        public function Modify($trigger=true)
        {
            $stringKey = '';
            if (!empty($this->_keys)) {
                /*$this->testKeys();*/
                foreach ($this->_keys as $key) {
                   $stringKey = $stringKey . $key->_value;
                }
                if (isset(Table::$_records[$this->_id][$stringKey])) {

                    if ($trigger == true) {
                        $this->onModify();
                    }
                    $this->Validate("modified_at", date('Y-m-d H:m:s'));
                    Table::$_records[$this->_id][$stringKey] = $this;
                    $modify = Database::base();
                    $modify->executeQuery($this->MySQL_UpdateQuery());
                    if($modify->getError()[1] != 0) {
                        header('updatable: true');
                        Error("Erreur SQL N°: " . $modify->getError()[1] . "<br>Message: " . $modify->getError()[2]);
                    }

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function Delete($trigger=true){
            $stringKey = '';
            if(!empty($this->_keys)) {
                /*$this->testKeys();*/
                foreach ($this->_keys as $key) {
                    $stringKey = $stringKey . $key->_value;
                }
                if($trigger == true){
                    $this->onDelete();
                }
                //if(isset(Table::$_records[$this->_id][$stringKey])) {
                    $delete = Database::base();
                    $delete->executeQuery($this->MySQL_DeleteQuery());
                    if($delete->getError()[1] != 0)
                        Error("Erreur SQL N°: ".$delete->getError()[1]."<br>Message: ".$delete->getError()[2]);
                    else
                        return true;
                /*}else{
                    return false;
                }*/
            }else
                return false;
        }
        
        public function onInsert(){}
        
        public function onDelete(){}
        
        public function onModify(){
        }
        
        public function onRename(){}

        public function testField($field){
            if($field == null)
                Error('Le champ est null');
            if($field->_value == null || $field->_value == '')
                Error('Le Champ "'.$field->_name.'" doit avoir une valeur dans l\'enregistrement "'. $this->_name.'"');
        }

        public function copyRecord($record)
        {
            $this->_keys = $record->_keys;
            $this->_name = $record->_name;
            $this->_id = $record->_id;
            $this->_current_keys = $record->_current_keys;
            $this->_fields = $record->_fields;
            $this->_recordSet = $record->_recordSet;
        }

        private function testKeys(){
            foreach ($this->_keys as $key) {
                $this->testField($key);
            }
        }

        public function AllKeysGiven(){
            $allGiven = true;
            foreach ($this->_keys as $key) {
                if($key->_value == null || $key->_value == '')
                    return false;
            }
            return $allGiven;
        }

        public function MySQL_CreateQuery(){
            $query = 'CREATE TABLE IF NOT EXISTS `'.$this->_name.'` ( ';
            foreach ($this->_fields as $field) {
                $query .= '`'.$field->_name.'` '.$field->_type.',';
            }
            $query .= 'PRIMARY KEY(`Id_slug`), UNIQUE(';
            foreach ($this->_keys as $key) {
                $query .= '`'.$key->_name.'`,';
            }
            $query = substr($query, 0,strlen($query)-1). ')
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8; ';

            return $query;
        }
        public function MySQL_UpdateSchema(){
            $query = 'ALTER TABLE `'.$this->_name.'` ';
            foreach ($this->_fields as $field) {
                if(!Database::base()->column_exist($this->_name, $field->_name))
                    $query .= ' ADD COLUMN `'.$field->_name.'` '.$field->_type.',';
            }
            $query = substr($query, 0,strlen($query)-1). '
            ;';


            return $query;
        }
        public function MySQL_InsertQuery(){
            $query = 'INSERT INTO `'.$this->_name.'` VALUES ( ';
            foreach ($this->_fields as $field) {
                $query .= '"'.$field->_value.'",';
            }
            $query = substr($query, 0,strlen($query)-1). '
            ) ON DUPLICATE KEY UPDATE deleted_at="0000-00-00 00:00:00";';


            return $query;
        }

        public function MySQL_SelectQuery(){
            $query = 'SELECT * FROM `'.$this->_name.'` WHERE `deleted_at` = "0000-00-00 00:00:00" ORDER BY `created_at` ASC';

            return $query;
        }

        public function MySQL_DeleteQuery(){
            $query = 'UPDATE `'.$this->_name.'` SET `deleted_at` = "'.date('Y-m-d H:m:s').'" WHERE ';
            foreach ($this->_keys as $key) {
                $query .= $key->_name.'="'.$key->_value.'" AND ';
            }
            $query = substr($query, 0,strlen($query)-4). ';';

            return $query;
        }

        public function MySQL_UpdateQuery(){
            $query = 'UPDATE `'.$this->_name.'` SET ';
            foreach ($this->_fields as $field) {
                if($field->_value != null) {
                    if($field->_value != '') {
                        $query .= $field->_name . '="' . $field->_value . '",';
                    }
                }
            }
            $query = substr($query, 0,strlen($query)-1). '
            WHERE ';

            foreach ($this->_keys as $key) {
                $query .= $key->_name.'="'.$key->_value.'" AND ';
            }
            $query = substr($query, 0,strlen($query)-4). ';';

            return $query;
        }
        public function loadTable(){
            Table::$_records[$this->_id] = array();
            $this->_recordSet = array();

            $data = Database::base();
            $datas = $data->getResultAssoc($this->MySQL_SelectQuery());
            if($data->getError()[1] != 0)
                Error("Erreur SQL N°: ".$data->getError()[1]."<br>Message: ".$data->getError()[2]);
            else if(!empty($datas)){
                $record = Table::$_tableCollection[$this->_name];
                foreach ($datas as $key => $value) {
                    $record = $record->reset();
                    foreach ($value as $key2 => $value2) {
                        if(!$record->Validate($key2, $value2))
                            Error('Erreur de validation des données');
                    }
                    Table::$_records[$this->_id][$record->keys] = $record;
                }

            }else{
                Table::$_records[$this->_id] = array();
                $this->_recordSet = array();
            }
        }

        public function reset(){
            return new ($this::Class);
        }
    }
    
?>