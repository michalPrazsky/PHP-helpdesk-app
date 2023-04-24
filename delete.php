<?php

require_once 'inc/user.php';



$stmt = $db->prepare("DELETE FROM TIKETY WHERE ID_TIKETU=?");
$stmt->execute([$_GET['id']]);

header('Location: UserTasks.php');

?>