<?php
include_once 'config.php';

header('Content-Type: application/json');
header('Access-Content-Allow-Origin: *');
header('Access-Content-Allow-Methods: POST');

$id = json_decode(file_get_contents('php://input'), true);
$id = $id['id'];
$s = "select * from student_2020 where id={$id} ";
$q = mysqli_query($connect, $s) or die("selecting single record is fail");

if(mysqli_num_rows($q) > 0){
    $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
    echo json_encode($data);
}
else{
    echo json_encode(array('data'=>'not found', 'status'=>false));
}

?>
