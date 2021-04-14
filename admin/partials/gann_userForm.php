<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;

// use Admin\Components\Gannwp_Input;
use Admin\Components\Gannwp_Input;

require_once plugin_dir_path(__FILE__) . '../components/input.php';


$table_users = $wpdb->prefix . "users";
$table_gannwp_users = $wpdb->prefix . "gannwp_users";
// $gannwp_users_roles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_roles", OBJECT);



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

}

$userClass = new Gannwp_Users;

$gannwp_users_fields = $userClass->getFields();
$gannwp_users_fields_meta = $userClass->getCustomFields();
$gannwp_users_roles = $userClass->getRoles();

var_dump($gannwp_users_fields_meta);


?>
<div class="wrap">
   <h1>Ajouter un utilisateur</h1>

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
         <tr>
            <td>
               <select class="" name="roleID">
                  <?php foreach ($gannwp_users_roles as $key => $value) {?>
                     <option value=<?php echo  $value->ID; ?>><?php echo $value->name ?></option>
                  <?php } ?>
               </select>
            </td>
         </tr>


         <?php foreach ($gannwp_users_fields_meta as $key => $value):
            $input = new Gannwp_Input($value);
            if ($value->COLUMN_NAME == 'userID' || $value->COLUMN_NAME == 'ID') {
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
