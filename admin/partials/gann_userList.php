<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;

$users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", OBJECT);
$gannwp_users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users", OBJECT);
$gannwp_users_roles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_roles", OBJECT);
$gannwp_users_fields_meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_meta", OBJECT);

$path = 'admin.php?page=gannwp%2Fadmin%2Fpartials%2Fgann_userForm.php';
$url = admin_url($path);



foreach ($gannwp_users as $key => $gannwp_user) {
   foreach ($users as $key => $user) {
      if ($user->ID == $gannwp_user->userID) {
         foreach ($gannwp_user as $key => $value) {
            $user->$key = $value;
         }
      }
   }
}

?>
<?php var_dump($_POST)  ?>
<div class="wrap">
   <h1>Liste des utilisateurs</h1>
   <form class="" action="" method="post">
      <table>
         <thead>
            <?php foreach ($gannwp_users_fields_meta as $key => $value) : ?>
               <th>
                  <?php echo $value->name ?>
               </th>
            <?php endforeach; ?>
            <th>
               Role
            </th>
         </thead>
         <?php foreach ($users as $key => $user) : ?>
            <tr>
               <?php foreach ($gannwp_users_fields_meta as $key => $field) : ?>
                  <?php $columnName = $field->columnName; ?>
                  <td>
                     <?php echo isset($user->$columnName) ? $user->$columnName : ''; ?>
                  </td>
               <?php endforeach; ?>
               <td>
                  <input type='hidden' name='field' value='' />
                  <select class="" name="role" onchange="this.form.field.value=this.name; this.form.submit()">
                     <option value="" >--Choisissez un role--</option>
                     <?php foreach ($gannwp_users_roles as $key => $value): ?>
                        <option value="<?php echo $value->ID ?>" <?php echo isset($user->roleID) && ($value->ID == $user->roleID) ? 'style="font-weight: bold;" selected' : "" ?> >
                           <?php echo $value->name ?>
                        </option>
                     <?php endforeach; ?>
                  </select>

               </td>
            </tr>
         <?php endforeach; ?>
      </table>
   </form>
</div>
