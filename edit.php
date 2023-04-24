<?php

require_once 'inc/user.php';

include "inc/header.php";

$pageTitle = 'Úprava požadavku';


$task_id = ($_GET['id']);
$taskCategory = '';
$taskName = '';
$taskPrio = '';
$taskDesc = '';
$taskUserId = '';

if (!empty($_GET['id'])) {
    $ticketQuery = $db->prepare('SELECT * FROM TIKETY WHERE ID_TIKETU=:id LIMIT 1;');
    $ticketQuery->execute([':id' => $_GET['id']]);
    if ($ticket = $ticketQuery->fetch(PDO::FETCH_ASSOC)) {
        $taskCategory = $ticket['ID_KATEGORIE'];
        $taskName = $ticket['NAZEV'];
        $taskPrio = $ticket['PRIORITY'];
        $taskDesc = $ticket['POPIS'];
        $taskUserId = $ticket['ID_UZIVATELE'];
    }
} else {
    exit('Požadavek není veden v databázi.');
}

if ($taskUserId != $_SESSION['user_id']) {
    header('Location: UserTasks.php');
}

$errors = [];
if (!empty($_POST)) {
    $taskName = @$_POST['taskName'];
    if (empty($taskName)) {
        $errors['taskName'] = 'Musíte zadat název požadavku!';
    }
    $taskDesc = @$_POST['taskDesc'];
    if (empty($taskDesc)) {
        $errors['taskDesc'] = 'Musíte požadavek specifikovat';
    }
}
if (empty($errors) AND isset($_POST['taskCategory'])) {
    $updateQuery = $db->prepare('UPDATE TIKETY SET NAZEV=:name, PRIORITY=:prio,ID_KATEGORIE=:category, POPIS=:desc WHERE ID_TIKETU=:id LIMIT 1;');
    $updateQuery->execute([
        ':name' => $taskName,
        ':prio' => $_POST['taskPriority'],
        ':category' => $_POST['taskCategory'],
        ':desc' => $taskDesc,
        ':id' => $task_id
    ]);

    header('Location: ticketinfo.php?id='.$task_id);

}

?>

<section id="hero" class="d-flex flex-column">
    <div class="container">
        <div class="px-4 py-5 my-5">
            <h2 class="fw-bold text-center">Úprava stávajícího požadavku</h2>
            <form method="post">
                <div class="form-group">
                    <label for="taskName">Název požadavku</label>
                    <input type="text" name="taskName"
                           class="form-control <?php echo(!empty($errors['taskName']) ? 'is-invalid' : ''); ?>"
                           id="taskName" placeholder="Název" value="<?php echo htmlspecialchars(@$taskName); ?>">
                    <?php
                    echo(!empty($errors['taskName']) ? '<div class="invalid-feedback">' . $errors['taskName'] . '</div>' : '');
                    ?>
                </div>
                <div class="form-group">
                    <label for="taskPriority">Priorita požadavku</label>
                    <select name="taskPriority" class="form-control" id="taskPriority">
                        <option value="Normální"<?php if ($taskPrio == "Normální") {
                            echo 'selected';
                        } ?>>Normální
                        </option>
                        <option value="Vysoká" <?php if ($taskPrio == "Vysoká") {
                            echo 'selected';
                        } ?>>Vysoká
                        </option>
                        <option value="Kritická"<?php if ($taskPrio == "Kritická") {
                            echo 'selected';
                        } ?>>Kritická
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="taskCategory">Vyberte kategorii požadavku</label>
                    <select name="taskCategory" class="form-control" id="taskCategory">
                        <?php
                        $categories = $db->query('SELECT * FROM KATEGORIE ORDER BY NAZEV;')->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                echo '<option value="' . $category['ID_KATEGORIE'] . '" ' . ($category['ID_KATEGORIE'] ==
                                    $taskCategory ? 'selected="selected"' : '') . '>' . htmlspecialchars($category['NAZEV']) . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="taskDesc">Přesnější popis problému</label>
                    <textarea class="form-control <?php echo(!empty($errors['taskDesc']) ? 'is-invalid' : ''); ?>"
                              name="taskDesc" id="taskDesc" value="<?php echo htmlspecialchars(@$taskDesc); ?>"
                              rows="5"><?php echo htmlspecialchars($taskDesc) ?></textarea>
                    <?php
                    echo(!empty($errors['taskDesc']) ? '<div class="invalid-feedback">' . $errors['taskDesc'] . '</div>' : '');
                    ?>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success">Odeslat změny v požadavku</button>
                    <button type="button" onclick="window.location.href='ticketinfo.php?id=<?=$task_id?>'"
                            class="btn btn-outline-secondary">Zrušit
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


<?php

require "inc/footer.php"

?>
