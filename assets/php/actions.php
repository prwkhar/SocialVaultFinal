<?php
require_once 'functions.php';

//for managing signup
if(isset($_GET['signup'])){
 $response=validatesignupform($_POST);
 if($response['status']){
   if(createUser($_POST)){
      header('location:../../?login');
   }
   else{
      echo "<script>alert('something is wrong')</script>";
   }
 }
 else{
    $_SESSION['error']=$response;
    $_SESSION['formdata']=$_POST;
    header("location:../../?signup");
 }
}

//for managing login
if(isset($_GET['login'])){
   // print_r(checkuser($_POST));
   $response=validateloginform($_POST);
   if($response['status']){
     $_SESSION['Auth']=true;
     $_SESSION['userdata']=$response['user'];
     header("location:../../");
   }
   else{
      $_SESSION['error']=$response;
      $_SESSION['formdata']=$_POST;
      header("location:../../?login");
   }
  }

  //forlogout
  if(isset($_GET['logout'])){
   session_destroy();
   header('location:../../');
  }

  if(isset($_GET['updateprofile'])){
   echo "<pre>";
   print_r($_POST);
   //$response=validateupdateprofileform($_POST,$_FILES['profile_pic']);
   //print_r($response);
//  if($response['status']){
//    if(createUser($_POST)){
//       header('location:../../?login');
//    }
//    else{
//       echo "<script>alert('something is wrong')</script>";
//    }
//  }
//  else{
//     $_SESSION['error']=$response;
//     $_SESSION['formdata']=$_POST;
//     header("location:../../?signup");
//  }
  }
  