<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;
$users = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users", OBJECT );
// var_dump($users)

?>
<div class="wrap">
   <h2>GannWP Agora Shortcode</h2>
   <form class="" action="index.html" method="post">
         <?php foreach ($users as $key => $user): ?>
            <div class="">

               <h3><?php echo $user->display_name; ?></h3>

            <table>

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
         </table>
      </div>
         <?php endforeach; ?>
   </form>
</div>
