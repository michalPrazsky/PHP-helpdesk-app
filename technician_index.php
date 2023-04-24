<?php

require "inc/db.php";

$pageTitle= "Homepage technika";

include "inc/header.php";

?>

<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="px-4 py-5 my-5  text-center">
            <div class="col-xl">
            </div><table class="table">

                <?php



                if(@$_GET['category']){
                    $query = $db->prepare('SELECT TIKETY.*, UZIVATELE.JMENO as user_name, UZIVATELE.PRIJMENI as user_surname, 
                    KATEGORIE.NAZEV as kategorie, TECHNICI.JMENO as technician_name, TECHNICI.PRIJMENI as technician_surname
             FROM TIKETY JOIN UZIVATELE USING (ID_UZIVATELE) JOIN KATEGORIE USING (ID_KATEGORIE) JOIN TECHNICI USING (ID_TECHNIKA) WHERE TIKETY.ID_KATEGORIE=:category
              ORDER BY STAV DESC,TIMESTAMP DESC;');

    $query->execute([
        ':category'=>$_GET['category']
    ]);

                }
                elseif(@$_GET['state']){
                    $query = $db->prepare('SELECT TIKETY.*, UZIVATELE.JMENO as user_name, UZIVATELE.PRIJMENI as user_surname, 
                    KATEGORIE.NAZEV as kategorie, TECHNICI.JMENO as technician_name, TECHNICI.PRIJMENI as technician_surname
             FROM TIKETY JOIN UZIVATELE USING (ID_UZIVATELE) JOIN KATEGORIE USING (ID_KATEGORIE) JOIN TECHNICI USING (ID_TECHNIKA) WHERE TIKETY.STAV=:stav
              ORDER BY TIMESTAMP DESC;');


    $query->execute([
        ':stav'=>$_GET['state']
    ]);
}


                
                else{
                    $query = $db->prepare('SELECT TIKETY.*, UZIVATELE.JMENO as user_name, UZIVATELE.PRIJMENI as user_surname, 
       KATEGORIE.NAZEV as kategorie, TECHNICI.JMENO as technician_name, TECHNICI.PRIJMENI as technician_surname
FROM TIKETY JOIN UZIVATELE USING (ID_UZIVATELE) JOIN KATEGORIE USING (ID_KATEGORIE) JOIN TECHNICI USING (ID_TECHNIKA)
 ORDER BY STAV DESC,TIMESTAMP DESC;');

                $query->execute();
            }
                $tickets = $query->fetchAll(PDO::FETCH_ASSOC);
                

                echo '<form method="get" id="categoryFilterForm">
                <label for="category">Kategorie:</label>
                <select name="category" id="category" onchange="document.getElementById(\'categoryFilterForm\').submit();">
                  <option value="">Nevybráno</option>';
      
        $categories=$db->query('SELECT * FROM KATEGORIE ORDER BY NAZEV;')->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($categories)){
          foreach ($categories as $category){
            echo '<option value="'.$category['ID_KATEGORIE'].'"';
            if ($category['ID_KATEGORIE']==@$_GET['category']){
              echo ' selected="selected" ';
            }
            echo '>'.htmlspecialchars($category['NAZEV']).'</option>';
          }
        }
      
        echo '  </select>
                <input type="submit" value="OK" class="d-none" />
              </form>';

              echo '<form method="get" id="StateFilterForm">
                <label for="state">Stav:</label>
                <select name="state" id="state" onchange="document.getElementById(\'StateFilterForm\').submit();">
                  <option value="">Nevybráno</option>
                  <option value="Otevřený" >Otevřený</option>
                  <option value="V řešení">V řešení</option>
                  <option value="Dokončen">Dokončen</option>
                  </select>
                <input type="submit" value="OK" class="d-none" />
              </form>';

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
        </div>
    </div>
    </div>
</section>
<?php

require "inc/footer.php"

?>
