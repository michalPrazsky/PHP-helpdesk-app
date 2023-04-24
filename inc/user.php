<?php

session_start();

require_once 'db.php';

if (!empty($_SESSION['user_id'])){
    $userQuery=$db->prepare('SELECT * FROM UZIVATELE WHERE ID_UZIVATELE=:id LIMIT 1;');
    $userQuery->execute([
        ':id'=>$_SESSION['user_id']
    ]);
    $currentUser = $userQuery->fetch(PDO::FETCH_ASSOC);
    if ($userQuery->rowCount()!=1){
        //uživatel už není v DB, nebo není aktivní => musíme ho odhlásit
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        header('Location: index.php');
        exit();
    }
}
else if (!empty($_SESSION['technician_id'])){
    $userQuery=$db->prepare('SELECT * FROM TECHNICI WHERE ID_TECHNIKA=:id LIMIT 1;');
    $userQuery->execute([
        ':id'=>$_SESSION['technician_id']
    ]);
    $currentUser = $userQuery->fetch(PDO::FETCH_ASSOC);
    if ($userQuery->rowCount()!=1){
        //uživatel už není v DB, nebo není aktivní => musíme ho odhlásit
        unset($_SESSION['technician_id']);
        unset($_SESSION['username']);
        header('Location: index.php');
        exit();
    }
}