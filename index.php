<?php
require_once 'assets/php/functions.php';
if(isset($_SESSION['Auth'])){
    $user = getuser($_SESSION['userdata']['id']);
}
$pagecount = count($_GET);
if(isset($_SESSION['Auth'])&& !$pagecount){
    showPage('header',['page_title'=>'Home']);
    showPage('navbar');
    showPage('wall');
}
elseif(!isset($_SESSION['Auth'])&&isset($_GET['signup'])){
showPage('header',['page_title'=>'Sociol Vault - Signup']);
showPage('signup');
}
elseif(isset($_SESSION['Auth']) && isset($_GET['editprofile'])){
    showPage('header',['page_title'=>'Edit Profile']);
    showPage('navbar');
    showPage('editprofile');
}
elseif(!isset($_SESSION['Auth'])&&isset($_GET['login'])){
    showPage('header',['page_title'=>'Sociol Vault - Login']);
    showPage('login');
}
else{
    if(isset($_SESSION['Auth'])){
        showPage('header',['page_title'=>'Home']);
        showPage('navbar');
        showPage('wall');
    }
    else{
    showPage('header',['page_title'=>'Sociol Vault - Login']);
    showPage('login');
    }
}
showPage('footer');
// unset($_SESSION['error']);
unset($_SESSION['formdata']);
?>