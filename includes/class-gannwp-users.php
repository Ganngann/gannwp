<?php

/**
* This class defines the users
*
* @since      1.0.0
* @package    Gannwp
* @subpackage Gannwp/components
* @author     Your Name <email@example.com>
*/


class Gannwp_Users
{

   /**
   * @var    string
   */
    public $wpdb;

    /**
    * @var    array
    */
    public $fields;

    /**
    * @var    array
    */
    public $customFields;

    /**
    * @var    array
    */
    public $defaultFields;


    /**
    * @var    array
    */
    public $roles;

    /**
    * Constructor
    *
    */
    public function __construct()
    {
        // acces wp global db var
        global $wpdb;
        $this->wpdb = $wpdb;

        // define table names
        $this->table_users = $this->wpdb->prefix . "users";
        $this->table_gannwp_users = $this->wpdb->prefix . "gannwp_users";
        $this->table_gannwp_users_roles = $this->wpdb->prefix . "gannwp_users_roles";
        $this->table_gannwp_users_meta = $this->wpdb->prefix . "gannwp_users_meta";
        $this->table_gannwp_users_fields_visibility = $this->wpdb->prefix . "gannwp_users_fields_visibility";



        // $this->setFieldsMeta();
      // $this->setRoles();
      // $this->setDefaultFields();
      // $this->setCustomFields();
    }



    /**
    * return user fields
    *
    * @return    array      user fields
    */
    public function getFields()
    {
        if ($this->fields == null) {
            $this->setFields();
        }
        return $this->fields;
    }

    /**
    * return user roles
    *
    * @return    array      user fields
    */
    public function getRoles()
    {
        if ($this->roles == null) {
            $this->setRoles();
        }
        return $this->roles;
    }


    /**
    * return user custom fields
    *
    * @return    array      user fields
    */
    public function getCustomFields()
    {
        if ($this->customFields == null) {
            $this->setCustomFields();
        }
        return $this->customFields;
    }

    /**
    * set custom fields
    *
    * @return    array      user fields
    */
    private function setCustomFields()
    {
        $this->customFields = $this->wpdb->get_results("
      select COLUMN_NAME, DATA_TYPE
      from INFORMATION_SCHEMA.COLUMNS
      where TABLE_NAME='{$this->table_gannwp_users}'
      ", OBJECT);

        $output = array();
        foreach ($this->customFields as $key => $cfield) {
            foreach ($this->getFields() as $key => $mfield) {
                if ($mfield->COLUMN_NAME == $cfield->COLUMN_NAME) {
                    foreach ($mfield as $key => $value) {
                        $cfield->$key = $value;
                    }
                    array_push($output, $cfield);
                }
            }
        }
        $this->customFields = $output;
    }

    /**
    * set custom fields
    *
    */
    public function setDefaultFields()
    {
        $this->defaultFields = $this->wpdb->get_results("
      select COLUMN_NAME, DATA_TYPE
      from INFORMATION_SCHEMA.COLUMNS
      where TABLE_NAME='{$this->table_users}'
      ", OBJECT);
    }

    /**
    * set  roles
    *
    */
    public function setRoles()
    {
        $this->roles = $this->wpdb->get_results("
      SELECT *
      FROM {$this->table_gannwp_users_roles}
       order by hyerarchy DESC", OBJECT);
    }

    /**
    * set  roles
    *
    */
    public function setFields()
    {
        $this->fields = $this->wpdb->get_results("
      SELECT *
      FROM {$this->table_gannwp_users_meta}
      ", OBJECT);
    }


    /**
    * set custom fields
    *
    * @return    array      user fields
    */
    public function activate()
    {
        $this->create_gannwp_users_meta();
        $this->create_gannwp_users_roles();
        $this->create_gannwp_users();
        $this->create_gannwp_users_fields_visibility();
    }

    /**
    * create_gannwp_users. (use period)
    *
    * create and seed gannwp_users table.
    *
    * @since    1.0.0
    */
    private function create_gannwp_users()
    {
        $alreadyexist;
        $table_name = $this->table_gannwp_users;
        $segond_table_name = $this->table_users;
        $third_table_name = $this->table_gannwp_users_roles;
        $gannwp_db_version = '1.0';
        $charset_collate = $this->wpdb->get_charset_collate();

        if ($this->wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $alreadyexist = false;
        } else {
            $alreadyexist = true;
        };
        $sql = "CREATE TABLE $table_name (
         userID BIGINT UNSIGNED UNIQUE,
         roleID int UNSIGNED,
         base_visibility int,
         FOREIGN KEY (userID) REFERENCES $segond_table_name(ID),
         FOREIGN KEY (roleID) REFERENCES $third_table_name(ID)
      ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        add_option('gannwp_db_version', $gannwp_db_version);

        // $this->wpdb->query("
        //     INSERT INTO $table_name
        //     (name, description)
        //     VALUES
        //     ('Admin', 'Administrateur')
        //     ");
    }


    /**
    * create_gannwp_users_meta. (use period)
    *
    * create and seed gannwp_users_meta table.
    *
    * @since    1.0.0
    */
    private function create_gannwp_users_meta()
    {
        $alreadyexist;
        $table_name = $this->table_gannwp_users_meta;
        $gannwp_db_version = '1.0';
        $charset_collate = $this->wpdb->get_charset_collate();

        if ($this->wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $alreadyexist = false;
        } else {
            $alreadyexist = true;
        };
        $sql = "CREATE TABLE $table_name (
         ID int UNSIGNED NOT NULL AUTO_INCREMENT,
         lastUpdate timestamp NOT NULL default CURRENT_TIMESTAMP,
         COLUMN_NAME tinytext NULL,
         name VARCHAR(60) NULL,
         dataType VARCHAR(40) NULL,
         inputType VARCHAR(40) NULL,
         description VARCHAR(255) NULL,
         PRIMARY KEY (ID)
         ) $charset_collate;
         ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        add_option('gannwp_db_version', $gannwp_db_version);

        $this->wpdb->query("INSERT INTO $table_name
         (COLUMN_NAME, name, dataType, inputType ,  description )
         VALUES
         ('ID', 'Id de l\'utilisateur', 'Nombre', 'text', 'description'),
         ('user_login', 'Login', 'text', 'text', 'description'),
         ('user_email', 'Email', 'text', 'text', 'description'),
         ('user_registered', 'date d\'ajout', 'date', 'text', 'description'),
         ('base_visibility', 'visibilité de base du profil', 'Nombre', 'text', 'description');
         ");
    }


    /**
    * create_gannwp_users_roles. (use period)
    *
    * create and seed gannwp_users_roles table.
    *
    * @since    1.0.0
    */
    private function create_gannwp_users_roles()
    {
        $alreadyexist;
        $table_name = $this->table_gannwp_users_roles;
        $gannwp_db_version = '1.0';
        $charset_collate = $this->wpdb->get_charset_collate();

        if ($this->wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $alreadyexist = false;
        } else {
            $alreadyexist = true;
        };
        $sql = "CREATE TABLE $table_name (
            ID int UNSIGNED NOT NULL AUTO_INCREMENT,
            lastUpdate timestamp NOT NULL default CURRENT_TIMESTAMP,
            name VARCHAR(60) NULL,
            hyerarchy int UNSIGNED,
            description VARCHAR(255) NULL,
            PRIMARY KEY (ID)
         ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        add_option('gannwp_db_version', $gannwp_db_version);

        $this->wpdb->query("
         INSERT INTO $table_name
         (name, hyerarchy, description)
         VALUES
         ('Admin',10, 'Administrateur'),
         ('Public',0, 'Utilisateur non enregistré')
         ");
    }

      /**
    * create_gannwp_users_fields_visibility. (use period)
    *
    * create and seed gannwp_users_fields_visibility table.
    *
    * @since    1.0.0
    */
    private function create_gannwp_users_fields_visibility()
    {
        $alreadyexist;
        $table_name = $this->table_gannwp_users_fields_visibility;
        $segond_table_name = $this->table_users;
        $third_table_name = $this->table_gannwp_users_meta;
//        $fourth_table_name = $this->table_gannwp_users_roles;
        $gannwp_db_version = '1.0';
        $charset_collate = $this->wpdb->get_charset_collate();

        if ($this->wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $alreadyexist = false;
        } else {
            $alreadyexist = true;
        };
        $sql = "CREATE TABLE $table_name (
         userID BIGINT UNSIGNED,
         fieldID int UNSIGNED,
         hyerarchy int UNSIGNED,
         FOREIGN KEY (userID) REFERENCES $segond_table_name(ID),
         FOREIGN KEY (fieldID) REFERENCES $third_table_name(ID)
         ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        add_option('gannwp_db_version', $gannwp_db_version);

      //   $this->wpdb->query("
      //    INSERT INTO $table_name
      //    (name, description)
      //    VALUES
      //    ('Admin', 'Administrateur')
      //    ");
    }
}
