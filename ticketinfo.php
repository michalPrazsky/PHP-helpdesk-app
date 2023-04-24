<?php

require "inc/db.php";

$pageTitle = "Informace o požadavku";

include "inc/header.php";

?>

<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="px-4 py-5 my-5  text-center">
            <div class="col-xl">
                <?php
                if (!empty($_GET['id'])) {
                    $ticketQuery = $db->prepare('SELECT TIKETY.*, UZIVATELE.JMENO as user_name, UZIVATELE.PRIJMENI 
    as user_surname, KATEGORIE.NAZEV as kategorie, TECHNICI.ID_TECHNIKA as technician_id,
       TECHNICI.JMENO as technician_name, TECHNICI.PRIJMENI as technician_surname
FROM TIKETY JOIN UZIVATELE USING (ID_UZIVATELE) JOIN KATEGORIE USING (ID_KATEGORIE) JOIN TECHNICI USING (ID_TECHNIKA)  
WHERE TIKETY.ID_TIKETU=:ticket_id LIMIT 1;');

                    $ticketQuery->execute([
                        ':ticket_id' => $_GET['id']
                    ]);

                    $tickets = $ticketQuery->fetchAll(PDO::FETCH_ASSOC);



                    if (empty($_SESSION['user_id'])) {
                        $_SESSION['user_id'] = 0;
                    }
                    if (empty($_SESSION['technician_id'])) {
                        $_SESSION['technician_id'] = 0;
                    }
                    foreach ($tickets as $ticket) {

                        if (($ticket['ID_UZIVATELE'] == $_SESSION['user_id']) || (!empty($_SESSION['technician_id']))) {
                            echo '<table class="table table-striped text-right">';
                            echo '<thead class="thead-dark fs-4">';
                            echo '<tr>';
                            echo '<th scope="col "><strong> Název požadavku: </strong></th>';
                            echo '<th scope="col ">' . htmlspecialchars($ticket['NAZEV']) . '</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td><strong> Datum založení požadavku:</strong></td>';
                            echo '<td>' . date('d.m.Y H:i', strtotime($ticket['TIMESTAMP'])) . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td><strong> Kategorie požadavku:</strong></td>';
                            echo '<td>' . htmlspecialchars($ticket['kategorie']) . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td><strong> Priorita požadavku:</strong></td>';
                            echo '<td>' . htmlspecialchars($ticket['PRIORITY']) . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td><strong> Stav požadavku:</strong></td>';
                            echo '<td>' . htmlspecialchars($ticket['STAV']) . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td><strong> Zadavatel požadavku:</strong></td>';
                            echo '<td>' . htmlspecialchars($ticket['user_name'] . ' ' . $ticket['user_surname']) . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td><strong> Řešitel požadavku:</strong></td>';
                            echo '<td>' . htmlspecialchars($ticket['technician_name'] . ' ' . $ticket['technician_surname']) . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td colspan="2"><strong> Popis problému: </strong></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td colspan="2">' . htmlspecialchars($ticket['POPIS']) . '</td>';
                            echo '</tr>';
                            if ($tickets[0]['STAV'] == "Dokončen") {
                                echo '<tr>';
                                echo '<td colspan="2"><strong> Popis řešení: </strong></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="2">' . htmlspecialchars($ticket['RESENI']) . '</td>';
                                echo '</tr>';

                            }
                            if ($tickets[0]['STAV'] == "V řešení" and !empty($_SESSION['technician_id']) and isset($_POST['resolution'])) {
                                print('testtest test');
                            }
                            echo '</tbody>';
                            echo '</table>';


                        } else {
                            echo '<div class="alert alert-danger text-center">Nemáte pravomoce na zobrazení tohoto tiketu</div>';
                        }
                    }



                if ($tickets[0]['ID_UZIVATELE'] == $_SESSION['user_id'] and $tickets[0]['STAV'] != "Dokončen") {

                    echo '<a class="btn btn-success btn-lg px-4 gap-3 justify-content-center" href="edit.php?id=' . $tickets[0]['ID_TIKETU'] . '" class="text-danger">Upravit</a>';
                    echo '<a class="btn btn-danger btn-lg px-4 gap-3 justify-content-center mx-2" href="delete.php?id=' . $tickets[0]['ID_TIKETU'] . '" class="text-danger">smazat</a>';

                }
                if ($tickets[0]['ID_TECHNIKA'] == 1 and !empty($_SESSION['technician_id'])and $tickets[0]['STAV'] != "Dokončen") {
                    echo '<a class="btn btn-success btn-lg px-4 gap-3 justify-content-center mx-2" href="takeTask.php?id=' . $tickets[0]['ID_TIKETU'] . '" class="text-danger">Převzít požadavek</a>';
                }
                if ($tickets[0]['ID_TECHNIKA'] == $_SESSION['technician_id'] and $tickets[0]['STAV'] != "Dokončen") {
                    echo '<a class="btn btn-primary btn-lg px-4 gap-3 justify-content-center" href="editTechnician.php?id=' . $tickets[0]['ID_TIKETU'] . '" class="text-danger">Upravit</a>';
                    echo '<button type="button" class="btn btn-info btn-lg px-4 gap-3 justify-content-center mx-2" data-bs-toggle="modal" data-bs-target="#PassModal">Předat požadavek</button>';
                    echo '<a class="btn btn-success btn-lg px-4 gap-3 justify-content-center mx-2" href="endTask.php?id=' . $tickets[0]['ID_TIKETU'] . '" class="text-danger">Zadat řešení</a>';
                }

                if (!empty($_SESSION['user_id'])) {
                    echo '<a href="UserTasks.php" class="btn btn-outline-secondary btn-lg px-4 gap-3 justify-content-center">Zpět</a>';
                } elseif (!empty($_SESSION['technician_id'])) {

                    echo '<a href="technician_index.php" class="btn btn-outline-secondary btn-lg px-4 gap-3 justify-content-center mx-2">Zpět</a>';
                } else {

                }

                } else {
                    echo '<div class="alert alert-danger text-center">Vámi hledaný tiket neexistuje</div>';
                }
                ?>

            </div>
        </div>
    </div>
</section>

<?php
if ($tickets[0]['STAV'] = "V řešení" and !empty($_SESSION['technician_id'])) {
    if (!empty($_POST)) {
        $PassQuery = $db->prepare('UPDATE TIKETY SET ID_TECHNIKA=:id_technika WHERE ID_TIKETU=:id_tiketu;');
        $PassQuery->execute([
            ':id_technika' => $_POST['PassSelect'],
            ':id_tiketu' => $_GET['id'],
        ]);
        header("Refresh:0");

    }
}


?>

<div class="modal" id="PassModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Vyberte technika, kterému chcete požadavek předat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <select name="PassSelect" class="form-control" id="PassSelect">
                            <?php
                            $technicians = $db->query('SELECT * FROM TECHNICI ORDER BY PRIJMENI;')->fetchAll(PDO::FETCH_ASSOC);
                            if (!empty($technicians)) {
                                foreach ($technicians as $technic) {
                                    echo '<option value="' . $technic['ID_TECHNIKA'] . '"';
                                    if ($technic['ID_TECHNIKA'] == @$_GET['technician']) {
                                        echo ' selected=' + $_SESSION[technician_id];
                                    }
                                    echo '>' . htmlspecialchars($technic['JMENO'] . " " . $technic['PRIJMENI']) . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Předej požadavek</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Zavři</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php

require "inc/footer.php"

?>
