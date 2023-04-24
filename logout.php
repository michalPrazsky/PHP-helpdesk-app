<?php
require_once 'inc/user.php';

if (!empty($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
}
else if(!empty($_SESSION['technician_id'])){
    unset($_SESSION['technician_id']);
    unset($_SESSION['username']);
}


header('Location: index.php');