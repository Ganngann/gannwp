<?php

$usersList = new Gannwp_User_list();
$users = $usersList->getUsers();
$roles = $usersList->getRoles();


$userId = get_current_user_id();
$datas = new stdClass();
$datas->ID = $userId;

$user = new Gannwp_User($datas);
$user->populate();

if ($userId != 0):
$userAuth = $user->getAuth()[0]->hyerarchy;
else:
$userAuth = 0;
endif;
//var_dump($userId);
//var_dump($userAuth);

?>
<div class="wrap">
    <h2>GannWP Agora Shortcode</h2>
    <table>
        <thead>
        <?php $index = 0 ?>
        <?php foreach ($usersList->getFields() as $key => $value) : ?>
            <th onclick="sortTable(<?php echo $index ?>)">
                <?php echo $value->name ?>
            </th>
            <?php $index++; ?>
        <?php endforeach; ?>
        </thead>
        <tbody id="myTable">
        <?php foreach ($users as $key => $userEl) : ?>
            <?php if (isset($userEl->base_visibility) && $userAuth >= $userEl->base_visibility) : ?>
                <tr>
                    <?php foreach ($usersList->getFields() as $key => $field) : ?>
                <?php $columnName = $field->COLUMN_NAME; ?>
                <td>
                    <form class="" action="" method="post" id="<?php echo $userEl->ID ?>"></form>
                    <?php echo isset($userEl->$columnName) ? $userEl->$columnName : ''; ?>
                </td>
            <?php endforeach; ?>
            </tr>
            <?php endif; ?>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>
