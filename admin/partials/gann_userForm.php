<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;

use Admin\Components\Gannwp_Input;
require_once plugin_dir_path(__FILE__) . '../components/input.php';


$table_users = $wpdb->prefix . "users";
$table_gannwp_users = $wpdb->prefix . "gannwp_users";

if (isset($_POST["create"])) {
   $data = array(
      'user_login' => $_POST["user_login"],
      'user_email' => $_POST["user_email"]
   );

   $id = wp_create_user($_POST["user_login"] , wp_rand() , $_POST["user_email"]);


   $newUserData = $_POST;
   unset($newUserData['create']);
   unset($newUserData['user_login']);
   unset($newUserData['user_email']);
   $newUserData['userID'] = $id;

   $result = $wpdb->insert($table_gannwp_users, $newUserData);

   var_dump($result);


   // $id = stripslashes_deep($_POST['ID']); //added stripslashes_deep which removes WP escaping.
   // $name = stripslashes_deep($_POST['name']);
   // $wpdb->update($table_gannwp_users_meta, array('ID'=>$id, 'name'=>$name), array('ID'=>$id));
   // echo '<div id="message" class="updated">le champ a été renomé</div>';
}
//
// if (isset($_POST["create"])) {
//    $column = str_replace( '-', '_',sanitize_html_class($_POST["create"]));
//    $dataType = $_POST["dataType"];
//
//    if (!in_array($column,$columnListe)) {
//       $sql = "ALTER TABLE $table_gannwp_users
//       ADD $column $dataType;";
//       $wpdb->query($sql);
//       $metadata = array(
//          'columnName' => $column,
//          'description' => 'la description',
//          'name' => $_POST["create"],
//          'dataType' => $typesOfData[$_POST["dataType"]]['name'],
//          'inputType' => $typesOfData[$_POST["dataType"]]['input']
//       );
//
//       $wpdb->insert($table_gannwp_users_meta, $metadata);
//       echo '<div id="message" class="updated">le champ a été ajouté</div>';
//    } else {
//       echo '<div id="message" class="error">Un champ porte déja cet identifiant</div>';
//    }
// };





// $users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", OBJECT);

$gannwp_users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users", OBJECT);
$gannwp_users_fields = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}gannwp_users;", OBJECT);
$gannwp_users_fields_meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_meta", OBJECT);

?>
<div class="wrap">
   <h1>GannWP Agora submenu</h1>

   <form class="" action="" method="post">
      <table>
         <tr>
            <td>
               <label for="user_login">Identifiant (nécessaire)</label>
            </td>
            <td>
               <input type="text" name="user_login" value="">
            </td>
         </tr>
         <tr>
            <td>
               <label for="">Adresse de messagerie (nécessaire)</label>
            </td>
            <td>
               <input type="email" name="user_email" value="">
            </td>
         </tr>


         <?php foreach ($gannwp_users_fields_meta as $key => $value):
            $input = new Gannwp_Input($value);
            if ($value->columnName == 'userID') {
            }else {
               ?>
               <tr>
                  <td>
                     <label for="<?php echo $input->getColumnName() ?>"><?php echo $input->getName() ?></label>
                  </td>
                  <td>
                     <?php echo $input->render() ?>
                  </td>
               </tr>
               <?php
            }
            ?>


         <?php endforeach; ?>
      </table>
      <input type="submit" name="create" value="envoyer">
   </form>

</div>
