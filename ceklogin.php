<?php
session_start();
$conn = mysqli_connect('localhost','root','','ujikom_laundry');

$username = stripslashes($_POST['username']);
$password = md5($_POST['password']);
$query = "SELECT * FROM user where username='$username' AND password = '$password'";
$row = mysqli_query($conn,$query);
$data = mysqli_fetch_assoc($row);
$cek = mysqli_num_rows($row);


if($cek > 0){
    if($data['role'] == 'admin'){
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['outlet_id'] = $data['outlet_id'];
        header('location:admin');
    }else if($data['role'] == 'kasir'){
        $_SESSION['role'] = 'kasir';
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['outlet_id'] = $data['outlet_id'];
        header('location:kasir/transaksi.php');
    }else if($data['role'] == 'owner'){
        $_SESSION['role'] = 'owner';
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['outlet_id'] = $data['outlet_id'];
        header('location:owner');
    }
}else{
    $msg = 'Username Atau Password Salah';
    header('location:index.php?msg='.$msg);
}
