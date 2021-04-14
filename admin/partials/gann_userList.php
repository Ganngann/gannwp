<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;

if (isset($_POST["user"])) {

   $user = new Gannwp_User($_POST);
   $user->db();

}

$usersList = new Gannwp_User_list();
$users = $usersList->getUsers();
$roles = $usersList->getRoles();


?>
<?php
// var_dump($_POST);
?>
<div class="wrap">
   <h1>Liste des utilisateurs</h1>
   <input id="myInput" type="text" placeholder="Search..">

   <table>
      <thead>
         <?php $index = 0 ?>
         <?php foreach ($usersList->getFields() as $key => $value) : ?>
            <th onclick="sortTable(<?php echo $index ?>)">
               <?php echo $value->name ?>
            </th>
            <?php $index ++; ?>
         <?php endforeach; ?>
         <th>
            Role
         </th>
      </thead>
      <tbody id="myTable">

         <?php foreach ($users as $key => $user) : ?>

            <tr>
               <?php foreach ($usersList->getFields() as $key => $field) : ?>
                  <?php $columnName = $field->COLUMN_NAME; ?>
                  <td>
                     <form class="" action="" method="post" id="<?php echo $user->ID ?>"></form>
                     <?php echo isset($user->$columnName) ? $user->$columnName : ''; ?>
                  </td>
               <?php endforeach; ?>
               <td>
                  <input type='hidden' name='user' value="update" form=<?php echo $user->ID ?> />
                  <input type='hidden' name='userID' value=<?php echo $user->ID ?> form=<?php echo $user->ID ?> />
                  <select class="" name="roleID" onchange="this.form.submit()" form=<?php echo $user->ID ?>>
                     <option value="" >--Choisissez un role--</option>
                     <?php foreach ($roles as $key => $value): ?>
                        <option value=<?php echo $value->ID ?> <?php echo isset($user->roleID) && ($value->ID == $user->roleID) ? 'style="font-weight: bold;" selected' : "" ?> >
                           <?php echo $value->name ?>
                        </option>
                     <?php endforeach; ?>
                  </select>

               </td>
            </tr>
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
