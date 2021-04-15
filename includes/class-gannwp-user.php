<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gannwp-users.php';


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
   private $table ;

   /**
   * Constructor
   *
   * @param   array       $data
   */
   public function __construct($data = array())
   {
      parent::__construct();

      $this->table = $this->wpdb->prefix . "gannwp_users";
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
   public function db()
   {
      if (isset($_POST["user"])) {

         switch ($_POST["user"]) {
            case 'update':
            $this->update();
            break;

            case 'create':
            $this->create();
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
   public function update()
   {

      $id = $this->datas['userID'];
      // $role = $this->datas['roleID'];
      $role = $this->datas['roleID'] == '' ? NULL : $this->datas['roleID'];
      $data = array(
         'userID' => $id,
         'roleID'  => $role,
      );

      // var_dump($id);

      $exist = $this->wpdb->get_row("SELECT * FROM $this->table WHERE userID = $id");
      // var_dump($data);
      if ($exist) {
         $this->wpdb->update($this->table,$data, array('userID'=>$this->datas['userID']));
      } else {
         $this->wpdb->insert($this->table,$data);
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

      $table_users = $this->wpdb->prefix . "users";
      $table_gannwp_users = $this->wpdb->prefix . "gannwp_users";


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

      $result = $this->wpdb->insert($table_gannwp_users, $newUserData);

      var_dump($result);

   }

}
