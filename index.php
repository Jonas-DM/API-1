<?php
//altijd param array

require_once("core/init.php");

use DigitalWorld\Business\DB;
use DigitalWorld\Business\Action;


// if($_SERVER['REQUEST_METHOD'] == "GET"){
//     if($_GET["url"] == "broodje"){
//         if(!isset($_GET["Naam"])):
//             echo '{"Error" : "Naam is niet megegeven."}';
//             http_response_code(404);
//             return;
//         endif;

//         if(empty($_GET["Naam"])){
//             if($db->query('SELECT * from broodje')){
//                 echo json_encode($db->getData());
//                 //echo ('{"BroodjesID":"1","Naam":"Bakbouw","Prijs":"10","Omschrijving":"Lekker broodje","Aanpassing":null}');
//                 http_response_code(200);
//             }

//             return;
//         }

//         if($db->query('SELECT * from broodje WHERE Naam=:naam', array(':naam' => $_GET["Naam"]))){
//             echo json_encode($db->getData());
//             //echo ('{"BroodjesID":"1","Naam":"Bakbouw","Prijs":"10","Omschrijving":"Lekker broodje","Aanpassing":null}');
//             http_response_code(200);
//         }
//     }
// }
// else{
//     if($_GET['url'] == "broodje"){
//        if(isset($_POST['field'])){
//            echo json_encode(array("status" => "200"));
//        }
//        else{
//         echo json_encode(array("status" => "20"));
//        }
//     }
// }

$SERVER_REQUEST = $_SERVER["REQUEST_METHOD"];
$action = new Action();

// switch($SERVER_REQUEST){
//     case 'POST':
//         switch($_POST['params'][0]["action"]){
//             case 'PUT':
//                 $action->Put($_POST['params']);
//                 break;
//             case 'DELETE':
//                 $action->Delete($_POST['params']);
//                 break;
//             case 'GET':
//                 $action->Get($_POST['params']);
//                 break;
//             default:
//                 $action->Post($_POST['val']);
//                 echo "{ 'message': 'qsdlghqs'}";
//                 break;
//         }
//         break;
// }

$action_type = $_POST["action"];

if(!isset($_POST["api_key"])){
    echo json_encode(array("status" => "404", "message" => "Geen API key gevonden."));
    return;
}

if(!$action->ValidKey($_POST["api_key"])){
    echo json_encode(array("status" => "404", "message" => "API key is niet gelden of is niet meer actief."));
    return;
}

if($_GET["url"] == "order"){
    switch($action_type){
        case "GET":
            $action->GetOrders($_POST);
            break;
        case "POST":
            $action->PostOrder($_POST);
            break;
    }
}
else{
    switch($action_type){
        case "GET":
            $action->Get($_POST);
            break;
        case "PUT":
            $action->Put($_POST);
            break;
        case "DELETE":
            $action->Delete($_POST);
            break;
        case "POST":
            $action->Post($_POST);
            break;
    }
}
// echo json_encode($_POST);
?>