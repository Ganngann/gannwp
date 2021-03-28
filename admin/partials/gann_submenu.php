<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;
$users = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users", OBJECT );
var_dump($users)

?>
<div class="wrap">
   <h1>GannWP Agora submenu</h1>
   <form class="" action="index.html" method="post">
      <table>
         <?php foreach ($users as $key => $user): ?>

            <?php foreach ($user as $key => $field): ?>
               <tr>

                  <td>
                     <label for="<?php echo $key ?>"><?php echo $key ?></label>
                  </td>
                  <td>
                     <input type="text" name="<?php echo $key ?>" value="<?php echo $field ?>">
                  </td>

               </tr>
            <?php endforeach; ?>

         <?php endforeach; ?>
      </table>
   </form>
</div>
