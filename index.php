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

    } else {
        http_response_code(400);
    }
   //fim do POST 
} 
/**
 * GETS
 */
elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    if($_GET['url']=='leads'){
//        $ob = new Leads();
//        if(isset($_GET['id'])){
//            echo json_encode($ob->getOne($_GET['user'], $_GET['id']));
//        } else {
//            echo json_encode($ob->getAll($_GET['user']));
//        }
//        http_response_code(200);
        
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