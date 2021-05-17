<?php

global $wpdb;

$table_gannwp_users_roles = $wpdb->prefix . "gannwp_users_roles";
$table_gannwp_users = $wpdb->prefix . "gannwp_users";


if (isset($_POST["delete"])) {
    $id = $_POST["ID"];


    $users = $wpdb->get_results("SELECT roleID, userID FROM $table_gannwp_users");

    $used = false;

    foreach ($users as $key => $user) {
        if (isset($user->roleID)) {
            if ($user->roleID == $id) {
                echo "<div id='message' class='error'>ce rôle est atribué a l'utilisateur $user->userID</div>";
                $used = true;
            }
        }

    }


    if ($used) {
        echo '<div id="message" class="error">Impossible de suprimer un rôle atribué à un ou des utilisateurs.</div>';
    } else {
        $wpdb->delete($table_gannwp_users_roles, array('id' => $id));

        echo '<div id="message" class="updated">le rôle a été suprimé</div>';
    }

}


if (isset($_POST["create"])) {
    $data = array(
        'description' => $_POST["description"],
        'name' => $_POST["name"]
    );

    $wpdb->insert($table_gannwp_users_roles, $data);
    echo '<div id="message" class="updated">le champ a été ajouté</div>';

}

if (isset($_POST["update"])) {
    $id = stripslashes_deep($_POST['ID']); //added stripslashes_deep which removes WP escaping.
    $name = stripslashes_deep($_POST['name']);

    $data = array(
        'description' => $_POST["description"],
        'name' => $_POST["name"],
        'ID' => $_POST["ID"]
    );

    $wpdb->update($table_gannwp_users_roles, $data, array('ID' => $id));
    echo '<div id="message" class="updated">le champ a été renomé</div>';
}

$gannwp_users_roles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_roles", OBJECT);


?>
<div class="wrap">

    <h2>Roles utilisateurs</h2>
    <div>
        <div>
            <span>nom</span>
            <span>Description</span>
            <span></span>

        </div>

        <?php foreach ($gannwp_users_roles as $key => $value) : ?>

            <div>
                <form class="" action="" method="post">

               <span>
                  <input type="text" name="name" maxlength="60" value="<?php echo $value->name ?>">
               </span>
                    <span>
                  <input type="text" name="description" maxlength="3" value="<?php echo $value->description ?>">
               </span>
                    <span>
                  <input type="hidden" name="ID" value="<?php echo $value->ID ?>"/>
                  <input type="submit" name="update" value="Update">
                  <input type="submit" name="delete" value="remove">
               </span>
                </form>

            </div>
        <?php endforeach; ?>
        <div>
            <form class="" action="" method="post">

            <span>
               <label for="name">ajouter un role</label>
               <input type="text" name="name" maxlength="60"
                      value="<?php echo substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"), 0, 5); ?>">
               <label for="description">ajouter une description</label>
               <input type="text" name="description" maxlength="60"
                      value="<?php echo substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"), 0, 5); ?>">

               <input type="submit" name="create" value="create">

            </span>
            </form>

        </div>
    </div>
</div>
