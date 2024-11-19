<?php


    class Database{

        private $_HOSTNAME;
        private $_USERNAME;
        private $_PASSWORD;
        private $_DBNAME;
        private $_Connect;
        private $_PORT;

        public static $database;


    /**
     * Database constructor.
     * @param $_HOSTNAME
     * @param $_USERNAME
     * @param $_PASSWORD
     * @param $_DBNAME
     */
    public function __construct($_HOSTNAME,$_PORT,$_USERNAME, $_PASSWORD, $_DBNAME)
    {
        $this->_HOSTNAME = $_HOSTNAME;
        $this->_USERNAME = $_USERNAME;
        $this->_PASSWORD = $_PASSWORD;
        $this->_DBNAME = $_DBNAME;
        $this->_PORT = $_PORT;
        try {
            $this->_Connect = new PDO("mysql:host=".$_HOSTNAME.";port=".$_PORT.";dbname=".$_DBNAME, $_USERNAME, $_PASSWORD);
            $this->_Connect->setAttribute(PDO::ERRMODE_WARNING, PDO::ATTR_ERRMODE);
            /*$this->_Connect = new PDO("sqlite:'F:\BestSeller V2\BestSeller\BestSeller\bin\Debug\Files\Best Seller2'");
            $this->_Connect->setAttribute(PDO::ERRMODE_WARNING, PDO::ATTR_ERRMODE);*/
        }catch (PDOException $e){
                    echo"Erreur de connexion à:  $_DBNAME; \n $e";
        }
    }

    public function getError(){
        return $this->_Connect->errorInfo();
    }

    public function getResult($query){
      if (!$this->_Connect->query($query))
        return false;
      else
        return $this->_Connect->query($query)->fetchAll();


    }

    public function getResultAssoc($query){
        return $this->_Connect->query($query)->fetchAll(PDO::FETCH_ASSOC);


    }

    public function executeQuery($query){
        try {
            return $this->_Connect->query($query);
        }
        catch(PDOException $e){
            return "Erreur requette SQL: $e";
        }
    }

    /**
     * @return mixed
     */
    public function getConnect()
    {
        return $this->_Connect;
    }

    /**
     * @param mixed $Connect
     */
    public function setConnect($Connect)
    {
        $this->_Connect = $Connect;
    }


    /**
     * @return mixed
     */
    public function getHOSTNAME()
    {
        return $this->_HOSTNAME;
    }

    /**
     * @param mixed $HOSTNAME
     */
    public function setHOSTNAME($HOSTNAME)
    {
        $this->_HOSTNAME = $HOSTNAME;
        $this->_Connect = new PDO("mysql:host=".$this->_HOSTNAME.";port=".$this->_PORT.";dbname=".$this->_DBNAME, $this->_USERNAME, $this->_PASSWORD);
        $this->_Connect->setAttribute(PDO::ERRMODE_WARNING, PDO::ATTR_ERRMODE);
    }

    /**
     * @return mixed
     */
    public function getUSERNAME()
    {
        return $this->_USERNAME;
    }

    /**
     * @param mixed $USERNAME
     */
    public function setUSERNAME($USERNAME)
    {
        $this->_USERNAME = $USERNAME;
        $this->_Connect = new PDO("mysql:host=".$this->_HOSTNAME.";port=".$this->_PORT.";dbname=".$this->_DBNAME, $this->_USERNAME, $this->_PASSWORD);
        $this->_Connect->setAttribute(PDO::ERRMODE_WARNING, PDO::ATTR_ERRMODE);
    }

    /**
     * @return mixed
     */
    public function getPASSWORD()
    {
        return $this->_PASSWORD;
    }

    /**
     * @param mixed $PASSWORD
     */
    public function setPASSWORD($PASSWORD)
    {
        $this->_PASSWORD = $PASSWORD;
        $this->_Connect = new PDO("mysql:host=".$this->_HOSTNAME.";port=".$this->_PORT.";dbname=".$this->_DBNAME, $this->_USERNAME, $this->_PASSWORD);
        $this->_Connect->setAttribute(PDO::ERRMODE_WARNING, PDO::ATTR_ERRMODE);
    }

    /**
     * @return mixed
     */
    public function getDBNAME()
    {
        return $this->_DBNAME;
    }

    /**
     * @param mixed $DBNAME
     */
    public function setDBNAME($DBNAME)
    {
        $this->_DBNAME = $DBNAME;
        $this->_Connect = new PDO("mysql:host=".$this->_HOSTNAME.";port=".$this->_PORT.";dbname=".$this->_DBNAME, $this->_USERNAME, $this->_PASSWORD);
        $this->_Connect->setAttribute(PDO::ERRMODE_WARNING, PDO::ATTR_ERRMODE);
    }


    public function column_exist($tableName, $columName){
        $r = $this->getResult("SHOW COLUMNS FROM $tableName LIKE '$columName'");
        return $r != false ? true : false;
    }
    public function table_exists($tableName){
        $r = $this->getResult("SHOW TABLES LIKE '$tableName'");
        return $r != false ? true : false;
    }

    public static function base(){
       return  new Database('deb-tech.net', '3306', 'dkrh8539', 'X?KI[$@PRmgD','dkrh8539_demo');
    }
}

?>
