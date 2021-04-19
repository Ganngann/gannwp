<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;
$params = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gannwp_params WHERE id = 1", OBJECT );
var_dump($params)

?>

<div class="wrap">
   <h1>GannWP Agora</h1>
   <form class="" action="index.html" method="post">

      <label for="premierParametre">parametre numero 1</label>
      <input type="text" name="premierParametre" value="<?php echo $params[0]->valueTXT ?>">


   </form>
</div>
