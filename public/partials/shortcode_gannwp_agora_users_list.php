<?php

$usersList = new Gannwp_User_list();
$users = $usersList->getUsers();
$roles = $usersList->getRoles();


$userId = get_current_user_id();
$datas = new stdClass();
$datas->ID = $userId;

$user = new Gannwp_User($datas);
$user->populate();

if ($userId != 0) :
    $userAuth = $user->getAuth();
else:
    $userAuth = 0;
endif;
//var_dump($userId);
//var_dump($userAuth);

?>
<div class="wrap">
    <h2>GannWP Agora Shortcode</h2>
    <select multiple="multiple" class="sumo headID" name="visibility[]" placeholder="Quels champs souhaitez vous afficher ?" ?>">
    <?php

    foreach ($usersList->getFields() as $key => $value):
      // wp_dump($value);

      ?>
        <?php
        // var_dump($value);
        ?>
            <option selected value="<?php echo $key ?>">
        <?php
        echo $value->name;
        ?>
            </option>
        <?php
    endforeach;
    ?>
    </select>
    <table>
        <thead class="tralalaHead">
        <?php $index = 0 ?>
        <?php foreach ($usersList->getFields() as $key => $value) : ?>
            <th onclick="sortTable(<?php echo $index ?>)">
                <?php echo $value->name ?>
                <!-- <input type="checkbox" checked="checked" /> -->
            </th>
            <?php $index++; ?>
        <?php endforeach; ?>
        </thead>
        <tbody id="myTable" class="tralala">
        <?php foreach ($users as $key => $userEl) : ?>
            <?php
            $userEl->populate();
            // var_dump($userEl->base_visibility) ;
            ?>
            <?php if (isset($userEl->base_visibility[$userAuth])) : ?>
                <tr>
                    <?php foreach ($usersList->getFields() as $key => $field) : ?>
                        <?php $columnName = $field->COLUMN_NAME; ?>
                <td>
                        <?php
                        // var_dump($userEl->getDatas());
                        ?>
                        <?php
                        if (isset($userEl->datas_visibility[$field->ID][$userAuth])) {
                            echo isset($userEl->getDatas()->$columnName) ? $userEl->getDatas()->$columnName : '';
                        }
                        ?>
                </td>
                    <?php endforeach; ?>
            </tr>
            <?php endif; ?>

        <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        jQuery(document).ready(function(){
            jQuery("#myInput").on("keyup", function() {

                var value = jQuery(this).val().toLowerCase();
                jQuery("#myTable tr").filter(function() {
                    jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        jQuery(document).on('change', '.headID', function() {
                jQuery('.tralala tr').each(function() {
                   jQuery(this).children('td').each(function(i, el) {
                      var checked = jQuery('.headID')[0][i].selected;
                      if(checked) {
                         jQuery(this).show();
                     } else {
                         jQuery(this).hide();
                     }
                     });
                });
                jQuery('.tralalaHead').each(function() {
                   jQuery('.tralalaHead th').each(function(index) {
                      var checked = jQuery('.headID')[0][index].selected;
                      if(checked) {
                        jQuery(this).show();
                     } else {
                        jQuery(this).hide();
                     }
                     });
                });
        });
        jQuery('.sumo').SumoSelect({placeholder: 'Qui peut voir mon profil', okCancelInMulti: true, selectAll: true});
    </script>

    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 0; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount ++;
                } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</div>
