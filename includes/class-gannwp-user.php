<?php

require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-gannwp-users.php';
require_once plugin_dir_path(__FILE__) . 'class-gannwp-input.php';


/**
 * This class defines the user.
 *
 * @since      1.0.0
 * @package    Gannwp
 * @subpackage Gannwp/components
 * @author     Your Name <email@example.com>
 */
class Gannwp_User extends Gannwp_Users
{
    /**
     * @var array
     */
    public $datas = array();

    /**
     * @var array
     */
    public $datas_visibility = array();

    /**
     * @var string
     */
    // private $table ;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct();

        $this->datas = $data;

    }

    /**
     * return user columnName
     *
     * @return string user columnName
     */
    public function getAuth()
    {
        return $this->datas->roleID;
    }

    /**
     * return user columnName
     *
     * @return string user columnName
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * return user columnName
     *
     * @return string user columnName
     */
    public function action()
    {
        if (isset($_POST["user"])) {

            switch ($_POST["user"]) {
            case 'set_base_visibility':
                $this->update();
                break;

            case 'updateRole':
                $this->updateRole();
                break;

            case 'create':
                $this->create();
                break;

            case 'update':
                $this->update();
                break;

            case 'updateFieldVisibility':
                $this->updateFieldVisibility();
                break;

            case 'logout':
                $this->logout();
                break;

            default:
                // code...
                break;
            }

        }
    }

    /**
     * add array of entities
     *
     * the given entities will be wrapped in a entity containers.
     * this entity containers are registred in a map storage by a given entity name.
     * the entity names are the keys of the given array.
     *
     * @param array $entities array of entities, the key of the array will be used as entity name
     */
    public function update()
    {
        $id = $this->datas->ID;

        $newData = $_POST;
        unset($newData['user']);

        // var_dump($newData);


        $exist = $this->wpdb->get_row("SELECT * FROM $this->table_gannwp_users WHERE userID = $id");
        // var_dump($newData);
        if ($exist) {
            $hello = $this->wpdb->update($this->table_gannwp_users, $newData, array('userID' => $this->datas->ID));
            // var_dump($hello);

        } else {
            $this->wpdb->insert($this->table_gannwp_users, $newData);
        }

        echo '<div id="message" class="updated">les changements ont été enregistrés</div>';

    }

    /**
     * add array of entities
     *
     * the given entities will be wrapped in a entity containers.
     * this entity containers are registred in a map storage by a given entity name.
     * the entity names are the keys of the given array.
     *
     * @param array $entities array of entities, the key of the array will be used as entity name
     */
    public function updateRole()
    {

        $id = $this->datas['userID'];
        // $role = $this->datas['roleID'];
        $role = $this->datas['roleID'] == '' ? null : $this->datas['roleID'];
        $data = array(
        'userID' => $id,
        'roleID' => $role,
        );

        // var_dump($id);

        $exist = $this->wpdb->get_row("SELECT * FROM $this->table_gannwp_users WHERE userID = $id");
        // var_dump($data);
        if ($exist) {
            $this->wpdb->update($this->table_gannwp_users, $data, array('userID' => $this->datas['userID']));
        } else {
            $this->wpdb->insert($this->table_gannwp_users, $data);
        }


        echo '<div id="message" class="updated">le rôle a été atribué</div>';

    }

    /**
     * add array of entities
     *
     * the given entities will be wrapped in a entity containers.
     * this entity containers are registred in a map storage by a given entity name.
     * the entity names are the keys of the given array.
     *
     * @param array $entities array of entities, the key of the array will be used as entity name
     */
    public function create()
    {

        $data = array(
        'user_login' => $this->datas["user_login"],
        'user_email' => $this->datas["user_email"]
        );

        $id = wp_create_user($this->datas["user_login"], wp_rand(), $this->datas["user_email"]);


        $newUserData = $this->datas;
        unset($newUserData['user']);
        unset($newUserData['user_login']);
        unset($newUserData['user_email']);
        $newUserData['userID'] = $id;

        $result = $this->wpdb->insert($this->table_gannwp_users, $newUserData);

        var_dump($result);

    }

    public function logout()
    {
        wp_logout();
        // echo '<div id="message" class="updated">Vous êtes déconnectés</div>';
    }

    /**
     * add array of entities
     *
     * the given entities will be wrapped in a entity containers.
     * this entity containers are registred in a map storage by a given entity name.
     * the entity names are the keys of the given array.
     *
     * @param array $entities array of entities, the key of the array will be used as entity name
     */
    public function populate()
    {

        // todo add if not exist
        $user = $this->wpdb->get_row("SELECT * FROM {$this->table_users} WHERE ID = {$this->datas->ID}", OBJECT);
        $gannwp_user = $this->wpdb->get_row("SELECT * FROM {$this->table_gannwp_users} WHERE userID = {$this->datas->ID}", OBJECT);
        $gannwp_visibility = $this->wpdb->get_results("SELECT * FROM {$this->table_gannwp_users_fields_visibility} WHERE userID = {$this->datas->ID}", OBJECT);

        // var_dump($gannwp_user);

        if ($gannwp_user != null) {
            foreach ($gannwp_user as $key => $value) {
                $user->$key = $value;
            }
        }
        $this->datas = $user;

        foreach ($gannwp_visibility as $key => $value) {
            // echo "<br>";
            // var_dump($value);

            $this->datas_visibility[$value->fieldID][$value->roleID] = $value;
        }
        // var_dump( $this->datas_visibility[5]);
        if (isset($this->datas_visibility[5])) {
           $this->base_visibility = $this->datas_visibility[5];
        }else {
           // $this->base_visibility = [];
        }

    }

    /**
     * add array of entities
     *
     * the given entities will be wrapped in a entity containers.
     * this entity containers are registred in a map storage by a given entity name.
     * the entity names are the keys of the given array.
     *
     * @param array $entities array of entities, the key of the array will be used as entity name
     */
    public function form()
    {



        echo <<<HEREDOC
		<form class="" action="" method="post">
		<input type='hidden' name='user' value="update" />
		<input type='hidden' name='userID' value="{$this->datas->ID}" />
		<table>
		HEREDOC;
        // var_dump($this->getCustomFields()[0]);
        // var_dump($this->datas_visibility);


        foreach ($this->getFields() as $key => $value):
            $inputValue = "";
            foreach ($this->datas as $key => $theValue) {
                if ($key == $value->COLUMN_NAME) {
                    $inputValue = $theValue;
                }
            }
            $input = new Gannwp_Input($value);

            ?>
			<tr>
			<td>
			<label for="<?php echo $input->getColumnName()?> "> <?php  echo $input->getName()?></label>
			</td>
			<td>
			<?php
         if ($input->getID() > 5) {
            echo $input->render($inputValue);
         }else {
            echo $inputValue;
         }
         ?>
			</td>
			<td>
			<?php
            // var_dump($this->datas_visibility[$input->getID()]);

            ?>

                 <select multiple="multiple" class="sumo" name="visibility[]" onchange="this.form.submit()" form="field-<?php echo $input->getID() ?>">
            <?php

            foreach ($this->roles as $key => $role): ?>
                <?php
                // var_dump($this->datas_visibility);
                ?>


                 <option value=<?php echo $role->ID ?>  <?php echo isset($this->datas_visibility[$input->getID()][$role->ID]) ? "selected" : "" ?>>
                <?php echo $role->name;


                ?>
                  </option>
            <?php endforeach; ?>

                 </select>
            <?php
            echo <<<HEREDOC
			</td>
			</tr>
			HEREDOC;

        endforeach;

        echo <<<HEREDOC
		</table>
		<input type="submit" name="" value="envoyer">
		</form>
		HEREDOC;
        foreach ($this->getFields() as $key => $value):
            echo "<form method='post' id='field-{$value->ID}'><input type='hidden' name='user' value='updateFieldVisibility' /><input type='hidden' name='userID' value={$this->datas->ID} />";
            echo "<input type='hidden' name='fieldID' value='{$value->ID}' /></form>";
            echo " <script>jQuery('.sumo').SumoSelect({placeholder: 'Qui peut voir ceci', okCancelInMulti: true, selectAll: true});</script>";
        endforeach;

    }

    /**
     * <option value=<?php echo $role->ID ?> <?php echo isset($this->datas_visibility[$role->ID][$input->getID()]) && ($this->datas_visibility[$role->ID]->fieldID == $input->getID()) ? 'selected' : "" ?>>
     */


    /**
     * add array of entities
     *
     * the given entities will be wrapped in a entity containers.
     * this entity containers are registred in a map storage by a given entity name.
     * the entity names are the keys of the given array.
     *
     * @param array $entities array of entities, the key of the array will be used as entity name
     */
    public function updateFieldVisibility()
    {
        $id = $this->datas->ID;

        $this->wpdb->delete($this->table_gannwp_users_fields_visibility, array( 'userID' => $id,'fieldID' => $_POST['fieldID'] ));
        if (isset($_POST['visibility'])) {
            foreach ($_POST['visibility'] as $key => $value) {
                $newData = $_POST;
                unset($newData['user']);
                unset($newData['visibility']);
                $newData['roleID'] = $value;
                $this->wpdb->insert($this->table_gannwp_users_fields_visibility, $newData);
            }
        }

        echo '<div id="message" class="updated">les changements ont été enregistrés</div>';

    }

}
