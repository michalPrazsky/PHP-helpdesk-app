<?php

require_once 'inc/user.php';

include "inc/header.php";

$pageTitle = 'Ukončení požadavku';

$task_id= $_GET['id'];
$taskState = "Dokončen";

if(!empty($_POST)) {

    $resolution= $_POST['resolution'];
    if(empty($resolution)){
        $errors = 'Musíte vyplnit řešení!';
    }


    if (empty($errors)) {
        $resolutionQuery = $db->prepare('UPDATE TIKETY SET RESENI=:resolution, STAV=:state WHERE ID_TIKETU=:id_tiketu;');
        $resolutionQuery->execute([
            ':resolution' => $_POST['resolution'],
            ':id_tiketu' => $_GET['id'],
            ':state' => $taskState
        ]);
        header('Location: ticketinfo.php?id='.$task_id);

    }
}


?>

    <section id="hero" class="d-flex flex-column">
        <div class="container">
            <div class="px-4 py-5 my-5">
                <h2 class="fw-bold text-center">Zadání řešení požadavku:</h2>
                <form method="post">
                    <div class="form-group">
                        <textarea class="form-control <?php echo (!empty($errors)?'is-invalid':''); ?>"
                                  name="resolution" id="resolution" value="<?php echo htmlspecialchars(@$resolution);?>" rows="5"></textarea>
                        <?php
                        echo (!empty($errors)?'<div class="invalid-feedback">'.$errors.'</div>':'');
                        ?>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">Odeslat požadavek</button>
                        <button type="button" onclick="window.location.href='ticketinfo.php?id=<?=$task_id?>'" class="btn btn-outline-secondary">Zrušit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php

require "inc/footer.php"

?>