<?php

namespace DigitalWorld\Business;
use \PDOStatement;
require_once 'core/init.php';

class DB{

    //properties
    private static $instance = null;
    private $pdo,
            $query,
            $result,
            $error = false,
            $count = 0;


    //return current pdo instance
    //if not exist create one
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function __construct()
    {
        try{
            //create PDO object
            $this->pdo = new \PDO('mysql:host='.Config::get("mysql/host").';dbname='.Config::get("mysql/database"), Config::get("mysql/user"), Config::get("mysql/wachtwoord"));
            
            //allow for PDO errors
            array(
                \PDO::ATTR_EMULATE_PREPARES=>false,
                \PDO::MYSQL_ATTR_DIRECT_QUERY=>false,
                \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
            );
        }
        catch(\PDOException $e){
            //There was an error creating the PDO object
            if(DEBUG){
                die($e->getMessage());
            }
        }
    }

    //execute the sql query 
    public function query($sql, $parameters = array()){

        //set errors to false
        $this->error = false;
        //prepare the query to be executed
        if($this->query = $this->pdo->prepare($sql)){
            $x = 1;
            if(count($parameters)){ //heeft 'parameters' waarde?
                /**
                 * Voor elke parameter binden we de waarde vast aan een plaats in de query
                 * vb. bindValue(1, parameter1)
                 *     bindValue(2, parameter2)
                 */
                foreach($parameters as $parameter){
                    $this->query->bindValue($x, $parameter);
                    $x++;
                }
            }
            //query uitvoeren
            if($this->query->execute()){
                $this->results = $this->query->fetchAll(\PDO::FETCH_OBJ); //obejct uit database halen
                $this->count = $this->query->rowCount(); //aantal rijen
            }
            else{ //check for errors
                if(DEBUG == false){
                    error_log($this->pdo->errorInfo(), 0);
                }
                //NOTE: log this and don't dump it
                var_dump($this->pdo->errorInfo());
                //var_dump(PDOStatement::errorInfo());
                $this->error = true;
            }
        }

        return $this;
    }

    //generate sql for get and delete statements

    /**
     * query opbouwen voor een get of delete vraag
     * $action = SELECT of DELETE
     * $table = tabel waar databse moet kijken
     * $where = - overal waar .. gelijk is aan een bepaalde waarde
     *          - is een array van 3 waarden
     *              1. veld die men wil controleren
     *              2. de operator (=, > ,< , ...)
     *              3. waarde die moet voldaan zijn
     */
    public function action($action , $table, $where){
        if(count($where) === 3){ //check als array niet meer of minder dan 3 waarden telt
            $operators = array("=", '>' ,"<", "<=", ">=", "LIKE");
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if(in_array($operator, $operators)){//check als de megegeven operator wel geldig is
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?"; //build sql query
                //call function query to execute query

                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }
        else{ // telt meer of minder dan 3 waarden, dus vragen we de hele tabel terug
            $sql = "{$action} FROM {$table}";
            if(!$this->query($sql, array())){
                return $this;
            }
        }
        return false;
    }

    //get row from database

    /**
     * Vraag een waarde uit de database
     * $action = SELECT
     * $table = de tabel
     * $geg = array met 3 waarden
     *        - het veld
     *        - operator
     *        - waarde waaraan moet voldaan worden
     */
    public function get($action, $table, $geg = array()){
        return $this->action($action, $table, $geg);
    }

    //insert row in database
    /**
     * $table = de tabel
     * $geg = array met de gegevens die moeten worden toegevoegd, waarbij de key's van de array de naam van de kolom is in de tabel
     *      vb = array("naam" => "Florian")
     *              ---de kolom--- ---de waarde---
     */
    public function insert($table, $geg = array()){
        if(count($geg)){ //hebben gegevens waarde
            $keys = array_keys($geg); //key's zijn kolomnamen in de tabel
            $values = '';
            $x = 1;
            //voeg elk gegeven to aan query builder
            foreach($geg as $gegeven){
                $values .= "?";
                if($x < count($geg)){
                    $values .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO {$table} (".implode(', ', $keys).") VALUES ({$values})"; //query opmaken zodat elke key overeen komt met de waarde in de values
            
            //pass query naar function query
            if(!$this->query($sql, $geg)->error()){
                return true;
            }
        }
        return false;
    }

    //delete row in database
    /**
     * delete waarde uit database
     * $table = tabel
     * $where = array van 3 waarden
     *          - veld
     *          - operator 
     *          - waarde waaraan moet voldaan worden
     */
    public function delete($table, $where = array()){
        return $this->action("DELETE", $table, $where);
    }

    //update field in database
    /**
     * rij updaten in database
     * $table = tabel
     * $id = de id van de rij die moet worden aangepast
     * $fields = de velden die moeten worden aangepast, de array key moet gelijk zijn aan de kolom in de tabel die moet worden aangepast
     */
    public function update($table, $id , $fields = array()){
        if(count($fields)){ //check als er wel velden zijn
            $x = 1;
            $set = '';
            foreach($fields as $name => $value){ //voor elk veld in 'fields' -> voeg het toe aan de query string
                $set .= "{$name} = ?";
                if($x < count($fields)){
                    $set .= ", ";
                }
                $x++;
            }
            $sql = "UPDATE {$table} SET {$set} where id = {$id}"; //query string verder aanpassen

            //pass query naar function query
            if(!$this->query($sql, $fields)->error()){
                return true;
            }
        }
        return false;
    }


    /* return errors from the exectued querys */
    public function error(){
        return $this->error;
    }
    
    //get amount of rows
    public function getCount(){
        return $this->count;
    }

    //get the results
    public function getResults(){
        return $this->results;
    }

    //get only the first result
    public function getFirstResult(){
        return $this->results[0];
    }

}