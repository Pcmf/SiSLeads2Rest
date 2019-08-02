<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
	header('Access-Control-Allow-Headers: token, Content-Type');
	die();
}
 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//require_once './class/Leads.php';
require_once './class/User.php';
require_once './class/Users.php';
require_once './class/Leads.php';
require_once './class/Mural.php';

/**
 * POST
 */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);
    
    if ($_GET['url'] == "login") {
        $ob = new User();
        $resp =   $ob->checkuser( $postBody->username, $postBody->password );
        if($resp){
            echo json_encode($resp);  
        } else {
            echo null;
        }
        http_response_code(200);

    } elseif($_GET['url']=="dashinfo"){

    } else {
        http_response_code(400);
    }
   //fim do POST 
} 
/**
 * GETS
 */
elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Dashboard
    if($_GET['url']=='dashinfo'){
        $ob = new Leads();
        echo json_encode($ob->getDashInfo($_GET['user']));
        http_response_code(200);
    // Mural    
    }  elseif($_GET['url']=='mural'){
        $ob = new Mural();
        if(isset($_GET['user'])){
            echo json_encode($ob->getMsg($_GET['user']));
        } else {
            echo json_encode($ob->getMuralUsers());
        }
        http_response_code(200);
    } else {
        http_response_code(400);
    }
    //fim dos GET
} 
/**
 * PUTS
 */
elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);   
    
    // Mural
    if($_GET['url']=='mural'){
        $ob = new Mural();
        echo json_encode($ob->sendMsg($postBody->origem, $postBody->destino, $postBody->assunto));
    }
      
    //fim dos PUT
}
/**
 * DELETES
 */
elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    
       
    //fim dos DELETE
} else {
    http_response_code(405);
}