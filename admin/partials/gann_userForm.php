<?php

use Admin\Components\Gannwp_Input;

require_once plugin_dir_path(__FILE__) . '../components/input.php';

$user = new Gannwp_User($_POST);

if (isset($_POST["user"])) {
   $user->action();
}

$gannwp_users_fields = $user->getFields();
$gannwp_users_fields_meta = $user->getCustomFields();
$gannwp_users_roles = $user->getRoles();


?>
<div class="wrap">
   <h1>Ajouter un utilisateur</h1>

   <form class="" action="" method="post">
      <input type='hidden' name='user' value="create" />

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

            ?>
            <tr>
               <td>
                  <label for="<?php echo $input->getColumnName() ?>"><?php echo $input->getName() ?></label>
               </td>
               <td>
                  <?php echo $input->render() ?>
               </td>
            </tr>



         <?php endforeach; ?>
      </table>
      <input type="submit" name="" value="envoyer">
   </form>

</div>
