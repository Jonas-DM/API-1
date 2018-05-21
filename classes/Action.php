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
        if(!isset($array["zoekterm"])){
            $this->db->type = "Get";
            $get = $this->db->get("SELECT *", $this->url, null);
            if($get->getCount() > 0){
                echo json_encode($get->getResults());
                return;
            }
            else{
                echo json_encode(array("status" => "400", "message" => "Niets gevonden."));
            }
        }
        else{
            $this->db->type = "Get";
            $get = $this->db->get("SELECT *", $this->url, json_decode($array["zoekterm"], true));
            if($get->getCount() > 0){
                echo json_encode($get->getResults());
                return;
            }
            else{
                echo json_encode(array("status" => "400", "message" => "Niets gevonden."));
            }
        }

        return;
    }

    public function Post($array){
        if(!isset($array["velden"])){
            echo json_encode(array("status" => "400", "message" => "Velden niet meegegeven."));
            return;
        }

        $this->db->type = "Post";
        if($this->db->insert($this->url, json_decode($array["velden"], true))){
            return true;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }

        return;
    }

    public function Put($array){
        if(!isset($array["velden"])){
            echo json_encode(array("status" => "400", "message" => "Velden niet meegegeven."));
            return;
        }

        if(!isset($array["id"])){
            echo json_encode(array("status" => "400", "message" => "Geen ID meegegeven."));
            return;
        }

        $this->db->type = "Put";
        if($this->db->update($this->url, $array["id"], json_decode($array["velden"], true))){
            return true;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }

        return;
    }

    public function Delete($array){
        if(!isset($array["id"])){
            echo json_encode(array("status" => "400", "message" => "ID niet meegegeven."));
            return;
        }

        $this->db->type = "Delete";
        if($this->db->delete($this->url, array("id", "=", $array["id"]))){
            return true;
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }
        
        return;
    }

    public function ValidKey($key){
        $api_key = $this->db->get("select *", "api", array("api_key", "=", $key));

        if($api_key->getCount() == 1){
            if($api_key->getFirstResult()->valid == true){
                return true;
            }
        }

        return false;
    }

    public function GetOrders($array){

    }

    public function PostOrder($array){
        if(!isset($array["velden"])){
            echo json_encode(array("status" => "400", "message" => "Velden niet meegegeven. Order"));
            return;
        }
        $this->db->type = "Post";

        if($this->db->insert($this->url, json_decode($array["velden"], true))){
            echo json_encode(array("error" => "false", "id"=>$this->db->getLastId()));
        }
        else{
            echo json_encode(array("status" => "400", "message" => "Er is iets fout gegaan."));
        }

        return;
    }

    public function PostOrderList($array){

    }
}