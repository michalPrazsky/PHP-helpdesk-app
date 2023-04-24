<?php

include "inc/user.php";

$task_id=$_GET['id'];

$taskStatus= "V řešení";
$StateQuery=$db->prepare('UPDATE TIKETY SET STAV=:status, ID_TECHNIKA=:technician WHERE ID_TIKETU=:id_tiketu;');
$StateQuery->execute([
':id_tiketu' =>$_GET['id'],
':status' => $taskStatus,
':technician' => $_SESSION['technician_id']

]);

header('Location: ticketinfo.php?id='.$task_id);


