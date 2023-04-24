<?php

require_once 'inc/user.php';

if (!empty($_SESSION['technician_id'])){

    header('Location: technician_index.php');
    exit();
}

$errors=false;
if (!empty($_POST)){

    $userQuery=$db->prepare('SELECT * FROM TECHNICI WHERE USERNAME=:username LIMIT 1;');
    $userQuery->execute([
        ':username'=>trim($_POST['username'])
    ]);
    if ($user=$userQuery->fetch(PDO::FETCH_ASSOC)){

        if (password_verify($_POST['password'],$user['HESLO'])){

            $_SESSION['technician_id']=$user['ID_TECHNIKA'];
            $_SESSION['username']=$user['USERNAME'];
            header('Location: technician_index.php');
            exit();
        }else{
            $errors=true;
        }

    }else{
        $errors=true;
    }
}
?>