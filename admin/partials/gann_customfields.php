<?php

global $wpdb;


$columnListeObj = $wpdb->get_results("SELECT columnName FROM {$wpdb->prefix}gannwp_users_meta", OBJECT);
$columnListe = array();
foreach ($columnListeObj as $key => $value) {
   array_push($columnListe, $value->columnName);
}

$table_gannwp_users = $wpdb->prefix . "gannwp_users";
$table_gannwp_users_meta = $wpdb->prefix . "gannwp_users_meta";
$typesOfData = array(
   'INT' => array(
      'input' => 'text',
      'name' => 'Nombre'
   ),
   'varchar(255)' => array(
      'input' => 'text',
      'name' => 'Texte court'
   ),
   'longtext' => array(
      'input' => 'textarea',
      'name' => 'Texte long'
   )
);

if (isset($_POST["delete"])) {
   $data = str_replace( '-', '_',sanitize_html_class($_POST["delete"]));
   $id = $_POST["ID"];

   $users = $wpdb->get_results("SELECT $data, userID FROM $table_gannwp_users");

   $used = false;

   foreach ($users as $key => $user) {
      if ($user->$data != "") {
         echo "<div id='message' class='error'>ce champ est utilisé par l'utilisateur $user->userID</div>";
         $used = true;
      }
   }

   if (!$used) {
      $sql = "ALTER TABLE $table_gannwp_users
      DROP COLUMN $data ;";
      $wpdb->query($sql);

      $wpdb->delete( $table_gannwp_users_meta, array( 'id' => $id ) );

      echo '<div id="message" class="updated">le champ a été suprimé</div>';}
   }

   if (isset($_POST["create"])) {
      $column = str_replace( '-', '_',sanitize_html_class($_POST["create"]));
      $dataType = $_POST["dataType"];

      if (!in_array($column,$columnListe)) {
         $sql = "ALTER TABLE $table_gannwp_users
         ADD $column $dataType;";
         $wpdb->query($sql);
         $metadata = array(
            'columnName' => $column,
            'description' => 'la description',
            'name' => $_POST["create"],
            'dataType' => $typesOfData[$_POST["dataType"]]['name'],
            'inputType' => $typesOfData[$_POST["dataType"]]['input']
         );

         $wpdb->insert($table_gannwp_users_meta, $metadata);
         echo '<div id="message" class="updated">le champ a été ajouté</div>';
      } else {
         echo '<div id="message" class="error">Un champ porte déja cet identifiant</div>';
      }
   };

   if (isset($_POST["update"])) {
      $id = stripslashes_deep($_POST['ID']); //added stripslashes_deep which removes WP escaping.
      $name = stripslashes_deep($_POST['name']);
      $wpdb->update($table_gannwp_users_meta, array('ID'=>$id, 'name'=>$name), array('ID'=>$id));
      echo '<div id="message" class="updated">le champ a été renomé</div>';
   }

   $gannwp_users_fields = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}gannwp_users;", OBJECT);
   $gannwp_users_fields_meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_meta", OBJECT);

   foreach ($gannwp_users_fields as $key => $field) {
      foreach ($gannwp_users_fields_meta as $key => $field_meta) {
         if ($field->Field == $field_meta->columnName) {
            $field->name = $field_meta->name;
         }
      }
   }


   ?>
   <div class="wrap">

      <h2>champs extras</h2>
      <table>
         <thead>
            <th>identifiant</th>
            <th>nom</th>
            <th>Type</th>
            <th></th>

         </thead>

         <?php foreach ($gannwp_users_fields_meta as $key => $value) : ?>

            <tr>
               <td>
                  <label for="name"><?php echo $value->columnName ?></label>
               </td>
               <td>
                  <form class="" action="" method="post">

                     <input type="text" name="name" maxlength="60" value="<?php echo $value->name ?>">
                     <input type="hidden" name="ID" value="<?php echo $value->ID ?>" />
                     <input type="submit" name="update" value="Update">
                  </form>
               </td>
               <td>
                  <?php echo $value->dataType ?>
               </td>
               <td>
                  <form class="" action="" method="post">
                     <input type="hidden" name="ID" value="<?php echo $value->ID ?>" />
                     <input type="hidden" name="delete" value="<?php echo $value->columnName ?>" />
                     <input type="submit" name="" value="remove">
                  </form>
               </td>
            </tr>
         <?php endforeach; ?>
         <tfoot>
            <td colspan="3">
               <form class="" action="" method="post">
                  <label for="create">ajouter un champ</label>
                  <input type="text" name="create" maxlength="60" value="<?php echo substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,5); ?>">
                  <select class="" name="dataType">
                     <?php foreach ($typesOfData as $key => $value) {?>
                        <option value=<?php echo $key; ?>><?php echo $value['name'] ?></option>
                     <?php } ?>
                  </select>
                  <input type="submit" name="" value="add">
               </td>
            </form>

         </tfoot>
      </table>
   </div>
