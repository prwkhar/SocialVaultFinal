<?php
require_once 'config.php';
// require_once 'signup.php';
$db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die("database is not connected");
//function for showing pages
function showPage($page,$data=""){
include("assets/pages/$page.php");
}

//function to show errors
function showerror($field)
{
    if(isset($_SESSION['error']))
    {
        $error=$_SESSION['error'];
        if($field==$error['field'])
        {
                ?>
                <div class="alert alert-danger my-2" role="alert">
                <?=$error['msg']?>;
                </div>
                <?php
        }
    }
}
//function for show previous form data
function showformdata($field)
{
    if(isset($_SESSION['formdata']))
    {
        $formdata=$_SESSION['formdata'];
        return $formdata[$field];
    }
}
// for checking duplicated email
// function isemailregistered($email){
//     global $db;
//     $query="select count(*) as row from users where email='$email'";
//     $run=mysqli_query($db,$query);
//     $return_data=mysqli_fetch_assoc($run);
//     return $return_data['row'];
// }
//checking for duplicate username
function isusernameregistered($username){
    global $db;
    $query="select count(*) as row from users where username='$username'";
    $run=mysqli_query($db,$query);
    $return_data=mysqli_fetch_assoc($run);
    return $return_data['row'];
}
//checking for duplicate username by other
function isusernameregisteredbyother($username){
    global $db;
    $id=$_SESSION['userdata']['id'];
    $query="select count(*) as row from users where username='$username' and id!='$id'";
    $run=mysqli_query($db,$query);
    $return_data=mysqli_fetch_assoc($run);
    return $return_data['row'];
}
function validatesignupform($form_data)
{
    $response=array();
    $response['status']=true;
    if(!$form_data['password']){
        $response['msg']="password is not given";
        $response['status']=false;
        $response['field']='password';
    }
    if(empty($form_data['username'])){
        $response['msg']="username is not given";
        $response['status']=false;
        $response['field']='username';
    }
    if(!$form_data['email']){
        $response['msg']="email is not given";
        $response['status']=false;
        $response['field']='email';
    }
    if(!$form_data['last_name']){
        $response['msg']="last name is not given";
        $response['status']=false;
        $response['field']='last_name';
    }
    if(!$form_data['first_name']){
        $response['msg']="first name is not given";
        $response['status']=false;
        $response['field']='first_name';
    }
    if(isusernameregistered($form_data['username'])){
        $response['msg']="username is already registered";
        $response['status']=false;
        $response['field']='username';
    }
    // if(!isemailregistered($form_data['email'])){
    //     $response['msg']="email is registered already";
    //     $response['status']=false;
    //     $response['field']='email';
    // }
    
    return $response;
}
//for validating login form
function validateloginform($form_data)
{
    $response = array();
    $response['status'] = true;

    // Check if the password field is empty
    if (empty($form_data['password'])) {
        $response['msg'] = "password is not given";
        $response['status'] = false;
        $response['field'] = 'password';
    } 
    // Check if the username field is empty
    elseif (empty($form_data['username'])) {
        $response['msg'] = "username is not given";
        $response['status'] = false;
        $response['field'] = 'username';
    } 
    // If neither field is empty, attempt to authenticate the user
    else {
        $userData = checkuser($form_data);
        // If user is found, set user data in response
        if (isset($userData['status']) && $userData['status']) {
            $response['user'] = $userData['user'];
        } 
        // If user is not found, set appropriate error message
        else {
            $response['msg'] = "Username or Password is incorrect";
            $response['status'] = false;
            $response['field'] = 'checkuser';
        }
    }

    return $response;
}

//for checking user
function checkuser($login_data)
{
    global $db;
    $username = $login_data['username'] ?? '';
    $password = md5($login_data['password'] ?? ''); // You should consider using more secure methods than md5 for hashing passwords
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $run = mysqli_query($db, $query);
    $data = [];
    if ($run && mysqli_num_rows($run) > 0) {
        $data['user'] = mysqli_fetch_assoc($run);
        $data['status'] = true;
    } else {
        $data['status'] = false; // Set status explicitly to false if user not found
    }
    return $data;
}

//for getting user data by id
function getuser($user_id)
{
    global $db;
    
    $query = "SELECT * FROM users WHERE id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}


//for creating user database
function createUser($data){
    global $db;
    $first_name = mysqli_real_escape_string($db,$data['first_name']);
    $last_name = mysqli_real_escape_string($db,$data['last_name']);
    $gender = $data['gender'];
    $email = mysqli_real_escape_string($db,$data['email']);
    $username = mysqli_real_escape_string($db,$data['username']);
    $password = mysqli_real_escape_string($db,$data['password']);
    $password = md5($password);
    $query = "INSERT INTO users (first_name, last_name, gender, email, username, password) 
          VALUES ('$first_name', '$last_name', $gender, '$email', '$username', '$password')";
    return mysqli_query($db,$query);
}
function validateupdateprofileform($form_data,$image_data)
{
    $response=array();
    $response['status']=true;
    if(!$form_data['password']){
        $response['msg']="password is not given";
        $response['status']=false;
        $response['field']='password';
    }
    if(empty($form_data['username'])){
        $response['msg']="username is not given";
        $response['status']=false;
        $response['field']='username';
    }
    if(!$form_data['last_name']){
        $response['msg']="last name is not given";
        $response['status']=false;
        $response['field']='last_name';
    }
    if(!$form_data['first_name']){
        $response['msg']="first name is not given";
        $response['status']=false;
        $response['field']='first_name';
    }
    if(isusernameregisteredbyother($form_data['username'])){
        $response['msg']=$form_data['username']." is already registered";
        $response['status']=false;
        $response['field']='username';
    }
    if($image_data['name']){
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image,PATHINFO_EXTENSION));
        $size = $image_data['size']/1000;
        if($type!='jpg'&& $type!='jpeg' && type!='png'){
            $response['msg']="only jpg,jpeg,png images are allowed";
            $response['status']=false;
            $response['field']='profile_pic';
        }
        if($size>1000){
            $response['msg']="upload image less than 1mb";
            $response['status']=false;
            $response['field']='profile_pic';
        }
    }
    
    return $response;
}
?>