<?php

require "inc/db.php";

$pageTitle= "Uživatelovy tasky";

include "inc/header.php";

?>
<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="px-4 py-5 my-5  text-center">
            <div class="col-xl">
            </div><table class="table">

                <?php

                $query = $db->prepare('SELECT TIKETY.*, UZIVATELE.JMENO as user_name, UZIVATELE.PRIJMENI as user_surname, 
       KATEGORIE.NAZEV as kategorie, TECHNICI.JMENO as technician_name, TECHNICI.PRIJMENI as technician_surname
FROM TIKETY JOIN UZIVATELE USING (ID_UZIVATELE) JOIN KATEGORIE USING (ID_KATEGORIE) JOIN TECHNICI USING (ID_TECHNIKA)
 WHERE TIKETY.ID_UZIVATELE=:user_id ORDER BY STAV DESC, TIMESTAMP DESC;');

                $query->execute([
                    ':user_id'=>$_SESSION['user_id']
                ]);

                $tickets = $query->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($tickets)){



                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th scope="col">#</th>';
                echo '<th scope="col">Datum</th>';
                echo'<th scope="col">Název</th>';
                echo'<th scope="col">Kategorie</th>';
                echo'<th scope="col">Priorita</th>';
                echo'<th scope="col">Status</th>';
                echo'<th scope="col">Zadavatel</th>';
                echo'<th scope="col">Řešitel</th>';
                echo'</tr>';
                echo '</thead>';


                foreach ($tickets as $ticket){
                echo '<tr>'; ?>

                <td><a class="text-decoration-none" href="ticketinfo.php?id=<?php echo $ticket['ID_TIKETU'];?>">
                        <?php echo htmlspecialchars($ticket['ID_TIKETU']);
                        echo '</a></td>';

                        echo '<td>'.date('d.m.Y H:i',strtotime($ticket['TIMESTAMP'])).'</td>';
                        echo '<td>'.htmlspecialchars($ticket['NAZEV']).'</td>';
                        echo '<td>'.htmlspecialchars($ticket['kategorie']).'</td>';
                        echo '<td>'.htmlspecialchars($ticket['PRIORITY']).'</td>';
                        echo '<td>'.htmlspecialchars($ticket['STAV']).'</td>';
                        echo '<td>'.htmlspecialchars($ticket['user_name'].' '.$ticket['user_surname']).'</td>';
                        echo '<td>'.htmlspecialchars($ticket['technician_name'].' '.$ticket['technician_surname']).'</td>';
                        echo '</tr>';
                        }
                        echo '</table>';
                        }else{
                            echo '<div class="alert alert-danger text-center">V tuto chvíli nemáte zadány žádné požadavky</div>';
                        }


                        ?>
                        <button type="button" onclick="window.location.href='user_index.php'" class="btn btn-outline-secondary btn-lg px-4 gap-3 justify-content-center">Zpět</button>
        </div>
    </div>
    </div>
</section>
<?php

require "inc/footer.php"

?>
