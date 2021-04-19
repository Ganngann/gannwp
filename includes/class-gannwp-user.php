<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gannwp-users.php';
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
   * @var    array
   */
   protected $datas = array();

   /**
   * @var    string
   */
   // private $table ;

   /**
   * Constructor
   *
   * @param   array       $data
   */
   public function __construct($data = array())
   {
      parent::__construct();

      $this->datas = $data;
   }

   /**
   * return user columnName
   *
   * @return    string      user columnName
   */
   public function getDatas()
   {
      return $this->datas;
   }


   /**
   * return user columnName
   *
   * @return    string      user columnName
   */
   public function action()
   {
      if (isset($_POST["user"])) {

         switch ($_POST["user"]) {
            case 'updateRole':
            $this->updateRole();
            break;

            case 'create':
            $this->create();
            break;

            case 'update':
            $this->update();
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
   * @param     array         $entities       array of entities, the key of the array will be used as entity name
   */
   public function updateRole()
   {

      $id = $this->datas['userID'];
      // $role = $this->datas['roleID'];
      $role = $this->datas['roleID'] == '' ? NULL : $this->datas['roleID'];
      $data = array(
         'userID' => $id,
         'roleID'  => $role,
      );

      // var_dump($id);

      $exist = $this->wpdb->get_row("SELECT * FROM $this->table_gannwp_users WHERE userID = $id");
      // var_dump($data);
      if ($exist) {
         $this->wpdb->update($this->table_gannwp_users,$data, array('userID'=>$this->datas['userID']));
      } else {
         $this->wpdb->insert($this->table_gannwp_users,$data);
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
   * @param     array         $entities       array of entities, the key of the array will be used as entity name
   */
   public function create()
   {

      $data = array(
         'user_login' => $this->datas["user_login"],
         'user_email' => $this->datas["user_email"]
      );

      $id = wp_create_user($this->datas["user_login"] , wp_rand() , $this->datas["user_email"]);


      $newUserData = $this->datas;
      unset($newUserData['user']);
      unset($newUserData['user_login']);
      unset($newUserData['user_email']);
      $newUserData['userID'] = $id;

      $result = $this->wpdb->insert($this->table_gannwp_users, $newUserData);

      var_dump($result);

   }

   /**
   * add array of entities
   *
   * the given entities will be wrapped in a entity containers.
   * this entity containers are registred in a map storage by a given entity name.
   * the entity names are the keys of the given array.
   *
   * @param     array         $entities       array of entities, the key of the array will be used as entity name
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
      $hello = $this->wpdb->update($this->table_gannwp_users,$newData, array('userID'=>$this->datas->ID));
      // var_dump($hello);

      } else {
         $this->wpdb->insert($this->table_gannwp_users,$newData);
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
   * @param     array         $entities       array of entities, the key of the array will be used as entity name
   */
   public function populate()
   {

      // todo add if not exist
      $user = $this->wpdb->get_row("SELECT * FROM {$this->table_users} WHERE ID = {$this->datas->ID}",  OBJECT);
      $gannwp_user = $this->wpdb->get_row("SELECT * FROM {$this->table_gannwp_users} WHERE userID = {$this->datas->ID}", OBJECT);

      // var_dump($gannwp_user);

      if ($gannwp_user != null) {
         foreach ($gannwp_user as $key => $value) {
            $user->$key = $value;
         }
      }
      $this->datas = $user;
   }


   /**
   * add array of entities
   *
   * the given entities will be wrapped in a entity containers.
   * this entity containers are registred in a map storage by a given entity name.
   * the entity names are the keys of the given array.
   *
   * @param     array         $entities       array of entities, the key of the array will be used as entity name
   */
   public function form()
   {
      echo <<<HEREDOC
      <form class="" action="" method="post">
      <input type='hidden' name='user' value="update" />
      <table>
      HEREDOC;

      foreach ($this->getCustomFields() as $key => $value):
         $inputValue = "";
         foreach ($this->datas as $key => $theValue) {
            if ($key == $value->COLUMN_NAME) {
               $inputValue = $theValue;
            }
         }
         $input = new Gannwp_Input($value);

         echo <<<HEREDOC
         <tr>
         <td>
         <label for="{$input->getColumnName()} "> {$input->getName()} </label>
         </td>
         <td>
         {$input->render($inputValue)}
         </td>
         </tr>
         HEREDOC;

      endforeach;

      echo <<<HEREDOC
      </table>
      <input type="submit" name="" value="envoyer">
      </form>
      HEREDOC;

   }

   public function logout(){
      wp_logout();
      // echo '<div id="message" class="updated">Vous êtes déconnectés</div>';
   }

}
