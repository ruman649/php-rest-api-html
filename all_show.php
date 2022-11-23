<?php
include_once 'config.php';

header('Content-Type: application/json');
// header('Access-Content-Allow-Method: GET');
header('Access-Content-Allow-Origin: *');
// header('Access-Content-Allow-Header: Access-Content-Allow-Header, Access-Content-Allow-Method, Content-Type, authorization, X-Requested-With');

$select = "select * from student_2020";
$q = mysqli_query($connect, $select);

if(mysqli_num_rows($q) > 0){
    $data = mysqli_fetch_all($q, MYSQLI_ASSOC);
    echo json_encode($data);
}
else{
    echo json_encode(array('data'=>'not found', 'status'=>false));
} 


?>
