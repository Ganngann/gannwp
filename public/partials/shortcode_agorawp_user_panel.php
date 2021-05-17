<?php
$userId = get_current_user_id();

$datas = new stdClass();
$datas->ID = $userId;


$user = new Gannwp_User($datas);
$roles = $user->getRoles();

// var_dump($_POST);


if (isset($_POST["user"])) {
    $user->action();
}

?>
<div class="wrap">
    <h2>AgoraWP user panel</h2>
    <?php
    if (!is_user_logged_in()) {
        wp_login_form();
    } else {
        $user->populate();
        ?>
    <form id="base_visibility" class="" action="" method="post">
        <input type="hidden" name="user" value="set_base_visibility">
        <input type="hidden" name="userID" value="<?php echo $userId?>">
        <select multiple="multiple" class="sumo" name="base_visibility[]" onchange="this.form.submit()" form="base_visibility">
            <?php foreach ($roles as $key => $value): ?>
                <option value=<?php echo $value->visibility ?> <?php echo isset($user->getDatas()->base_visibility) && ($value->ID == $user->getDatas()->base_visibility) ?  'selected' : "" ?>>
                    <?php echo $value->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

        <?php
        $user->form();
        ?>
        <form class="" action="" method="post">
            <input type="hidden" name="user" value="logout">
            <input type="submit" name="user" value="logout">
        </form>
        <?php
    }
    ?>
    <script>
        jQuery('.sumo').SumoSelect({placeholder: 'Qui peut voir mon profil', okCancelInMulti: true, selectAll: true});
    </script>
</div>
