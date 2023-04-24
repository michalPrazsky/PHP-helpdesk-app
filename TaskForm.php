<?php

require "inc/user.php";


$errors=[];
if (!empty($_POST)) {
    $taskName = @$_POST['taskName'];
    if (empty($taskName)) {
        $errors['taskName'] = 'Musíte zadat název požadavku!';
    }
    $taskDesc = @$_POST['taskDesc'];
    if (empty($taskDesc)) {
        $errors['taskDesc'] = 'Musíte požadavek specifikovat';
    }
    $taskState = "Otevřený";
    $userId = $_SESSION["user_id"];
    $technicianId= 1;

    if (empty($errors)) {

        $query = $db->prepare('INSERT INTO TIKETY (ID_UZIVATELE,ID_KATEGORIE,ID_TECHNIKA,NAZEV, POPIS, STAV, PRIORITY) 
VALUES (:userId,:taskCategory,:technicianId,:taskName, :taskDesc, :taskState, :taskPriority);');
        $query->execute([
            ':userId' => $userId,
            ':taskCategory' => $_POST['taskCategory'],
            ':technicianId' => $technicianId,
            ':taskName' => $taskName,
            ':taskDesc' => $taskDesc,
            ':taskState' => $taskState,
            ':taskPriority' => $_POST['taskPriority']
        ]);

        header('Location: user_index.php');
        exit();
    }
}

$pageTitle= "Nový požadavek";

include "inc/header.php";

?>

<section id="hero" class="d-flex flex-column">
    <div class="container">
        <div class="px-4 py-5 my-5">
            <h2 class="fw-bold text-center">Zadání nového požadavku</h2>
<form method="post">
    <div class="form-group">
        <label for="taskName">Název požadavku</label>
        <input type="text" name="taskName" class="form-control <?php echo (!empty($errors['taskName'])?'is-invalid':''); ?>"
               id="taskName" placeholder="Název" value="<?php echo htmlspecialchars(@$taskName);?>">
        <?php
        echo (!empty($errors['taskName'])?'<div class="invalid-feedback">'.$errors['taskName'].'</div>':'');
        ?>
    </div>
    <div class="form-group">
        <label for="taskPriority">Priorita požadavku</label>
        <select name="taskPriority" class="form-control" id="taskPriority">
            <option value="Normální" >Normální</option>
            <option value="Vysoká" selected>Vysoká</option>
            <option value="Kritická">Kritická</option>
        </select>
    </div>
    <div class="form-group">
        <label for="taskCategory">Vyberte kategorii požadavku</label>
        <select name="taskCategory" class="form-control" id="taskCategory">
            <?php
            $categories=$db->query('SELECT * FROM KATEGORIE ORDER BY NAZEV;')->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($categories)){
            foreach ($categories as $category){
                echo '<option value="'.$category['ID_KATEGORIE'].'"';
                if ($category['ID_KATEGORIE']==@$_GET['category']){
                    echo '  selected="selected"';
                }
                echo '>'.htmlspecialchars($category['NAZEV']).'</option>';
            }}

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="taskDesc">Přesnější popis problému</label>
        <textarea class="form-control <?php echo (!empty($errors['taskDesc'])?'is-invalid':''); ?>"
                  name="taskDesc" id="taskDesc" value="<?php echo htmlspecialchars(@$taskDesc);?>" rows="5"></textarea>
        <?php
        echo (!empty($errors['taskDesc'])?'<div class="invalid-feedback">'.$errors['taskDesc'].'</div>':'');
        ?>
    </div>
    <div class="text-center mt-3">
    <button type="submit" class="btn btn-success">Odeslat požadavek</button>
    <button type="button" onclick="window.location.href='user_index.php'" class="btn btn-outline-secondary">Zrušit</button>
    </div>
</form>
        </div>
    </div>
</section>
<?php

require "inc/footer.php"

?>