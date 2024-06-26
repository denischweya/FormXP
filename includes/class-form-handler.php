<?php

class Database_Handler
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'custom_data';
    }

    public static function create_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_data';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            message text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function insert_data($data)
    {
        global $wpdb;
        return $wpdb->insert($this->table_name, $data);
    }

    public function get_data($search = '')
    {
        global $wpdb;
        if ($search) {
            $query = $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE name LIKE %s OR email LIKE %s OR message LIKE %s",
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%'
            );
        } else {
            $query = "SELECT * FROM {$this->table_name}";
        }
        return $wpdb->get_results($query);
    }
}
