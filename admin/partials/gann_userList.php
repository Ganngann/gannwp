<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;
$users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", OBJECT);
var_dump($users)

?>
<div class="wrap">
   <h1>GannWP Agora submenu</h1>
   <form class="" action="index.html" method="post">
      <table>
         <thead>
            <?php foreach ($users[0] as $key => $value) : ?>
               <th>
                  <?php echo $key ?>
               </th>
            <?php endforeach; ?>
         </thead>
         <?php foreach ($users as $key => $user) : ?>
            <tr>
               <?php foreach ($user as $key => $field) : ?>
                  <td>
                     <?php echo $field ?>
                  </td>
               <?php endforeach; ?>
            </tr>
         <?php endforeach; ?>
      </table>
   </form>
</div>