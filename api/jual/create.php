<?php 
 
$conn = mysqli_connect("localhost","nandohidayat", "", "penjualan"); 

$gerai = $_GET['gerai'];
$puser = $_GET['username']; 
$ptotal = $_GET['total']; 
$pbayar = $_GET['bayar']; 
$items = $_GET['items'];
 
$query = "INSERT 
            INTO 
                jual (kd_gerai, user_id, total, bayar) 
            VALUES 
                ('".$gerai."','".$puser."',".$ptotal.",".$pbayar.")"; 

$data = array();

if(mysqli_query($conn, $query)) {      
    $last_id = mysqli_insert_id($conn);
    $data[0]['status0'] = 'success';
} else {
    $data[0]['status0'] = 'failed'; 
}

$query = "INSERT
            INTO
                list_jual (id_jual, kd_brg)
            VALUES
                ('".$last_id."', '".$items[0]."')";

for($i = 1; $i < sizeof($items); $i++) {
    $query .= ", ('".$last_id."', '".$items[$i]."')";
}

if(mysqli_query($conn, $query)) {
    $data[0]['status1'] = 'success';
} else {
    $data[0]['status1'] = 'failed';
}

$data[0]['pdf'] = 'http://ayam-ku-nandohidayat.c9users.io/api/jual/pdf.php?gerai='.$gerai.'&username='.$puser.'&total='.$ptotal.'&bayar='.$pbayar.'&id_jual='.$last_id.'';

for($i = 0; $i < sizeof($items); $i++) {
    $data[0]['pdf'] .= '&items[]='.$items[$i].'';
}

echo json_encode($data);

mysqli_close($conn); 
 
?> 