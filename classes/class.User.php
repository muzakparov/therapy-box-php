<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 26/01/2018
 * Time: 06:14
 */

class User{
    private $db;

    private $host='localhost';
    private $dbname='therapy_box';
    private $username='root';
    private $passw='';
    private $table='users';

    public function __construct(){
        try {
            $db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->passw);
            $this->db = $db;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRows($conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$this->table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $stmt->rowCount();
                    break;
                case 'single':
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch(pdo::FETCH_ASSOC)){
                    $data[] = $row;
                }
            }
        }
        return !empty($data)?$data:false;
    }

    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            if(!array_key_exists('created',$data)){
                $data['created'] = date("Y-m-d H:i:s");
            }
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $columns .= $pre.$key;
                $values  .= $pre."'".$val."'";
                $i++;
            }
            $sql = "INSERT INTO ".$this->table." (".$columns.") VALUES (".$values.")";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
}