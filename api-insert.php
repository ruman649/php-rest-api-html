<?php
include_once 'config.php';

header('Content-Type: application/json');
header('Access-Content-Allow-Methods: POST');
header('Access-Content-Allow-Origin: *');
header('Access-Content-Allow-Header: Content-Type,Access-Content-Allow-Methods,Access-Content-Allow-Header, authorization, X-Requested-With');

$arr = json_decode(file_get_contents('php://input'), true);

$name = $arr['sname'];
$phone = $arr['sphone'];
$roll = $arr['sroll'];
$regis = $arr['sregis'];

if($name=='' || $phone=='' || $roll=='' || $regis==''){
    echo json_encode(array('data'=>'Data not inserted', 'status'=>false));
}else{
    $i = "insert into student_2020 (name, phone, roll, regis) values ('{$name}', '{$phone}', '{$roll}', '{$regis}') ";
    
    $q = mysqli_query($connect, $i) or die('this is fail');
    
    if($q){
        echo json_encode(array('data'=>'Data inserted successfully', 'status'=>true));
    }
    else{
        echo json_encode(array('data'=>'Data not inserted', 'status'=>false));
    }
}
    


?>
