<?php
$userId = get_current_user_id();

$datas = new stdClass();
$datas->ID = $userId;


$user = new Gannwp_User($datas);
$roles = $user->getRoles();


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
        <select class="" name="base_visibility" onchange="this.form.submit()" form="base_visibility">
            <option value="">--Qui peut voir mon profil--</option>
            <?php foreach ($roles as $key => $value): ?>
                <option value=<?php echo $value->hyerarchy ?> <?php echo isset($user->getDatas()->base_visibility) && ($value->ID == $user->getDatas()->base_visibility) ? 'style="font-weight: bold;" selected' : "" ?>>
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
</div>
