<?php

namespace DigitalWorld\Business;

class Action{

    private $db;
    private $url;

    public function __construct()
    {
        $this->db = DB::getInstance();
        $this->url = $_GET['url'];
    }

    public function Get($array){
        if(!$this->ValidKey($array[0]["api_key"])){
            echo json_encode(array("status" => "404", "message" => "API key is niet gelden of is niet meer actief"));
            return;
        }

        if(!isset($array[0]["naam"])){
            echo json_encode(array("status" => "400", "message" => "Naam niet meegegeven."));
            return;
        }

        $get = $this->db->get("SELECT *", $this->url, array("naam", "LIKE", $array[0]["naam"]));
        if($get->getCount() > 0){
            echo json_encode($get->getResults());
            return;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Niets gevonden."));
        }

        return;
    }

    public function Post($array){
        if(!$this->ValidKey($array[0]["api_key"])){
            echo json_encode(array("status" => "404", "message" => "API key is niet gelden of is niet meer actief"));
            return;
        }

        if(!isset($array[0]["velden"])){
            echo json_encode(array("status" => "400", "message" => "Velden niet meegegeven."));
            return;
        }

        if($this->db->insert($this->url, $array[0]["velden"])){
            return true;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }

        return;
    }

    public function Put($array){
        if(!$this->ValidKey($array[0]["api_key"])){
            echo json_encode(array("status" => "404", "message" => "API key is niet gelden of is niet meer actief"));
            return;
        }

        if(!isset($array[0]["velden"])){
            echo json_encode(array("status" => "400", "message" => "Velden niet meegegeven."));
            return;
        }

        if(!isset($array[0]["id"])){
            echo json_encode(array("status" => "400", "message" => "Geen ID meegegeven."));
            return;
        }

        if($this->db->update($this->url, $array[0]["id"], $array[0]["velden"])){
            return true;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }

        return;
    }

    public function Delete($array){
        if(!$this->ValidKey($array[0]["api_key"])){
            echo json_encode(array("status" => "404", "message" => "API key is niet gelden of is niet meer actief"));
            return;
        }

        if(!isset($array[0]["id"])){
            echo json_encode(array("status" => "400", "message" => "ID niet meegegeven."));
            return;
        }

        if($this->db->delete($this->url, array("id", "=", $array[0]["id"]))){
            return true;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }
        
        return;
    }

    private function ValidKey($key){
        $api_key = $this->db->get("select *", "api", array("api_key", "=", $key));

        if($api_key->getCount() == 1){
            if($api_key->getFirstResult()->valid == true){
                return true;
            }
        }

        return false;
    }
}