<?php

class API_Handler
{
    private $db_handler;
    private $namespace = 'formxp/v1';

    public function __construct($db_handler)
    {
        $this->db_handler = $db_handler;
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes()
    {
        register_rest_route($this->namespace, '/data', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_data'),
                'permission_callback' => array($this, 'get_data_permissions_check'),
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'insert_data'),
                'permission_callback' => array($this, 'insert_data_permissions_check'),
            ),
        ));
    }

    public function get_data($request)
    {
        $search = $request->get_param('search');
        $data = $this->db_handler->get_data($search);
        return new WP_REST_Response($data, 200);
    }

    public function insert_data($request)
    {
        $name = sanitize_text_field($request->get_param('name'));
        $email = sanitize_email($request->get_param('email'));
        $message = sanitize_textarea_field($request->get_param('message'));

        if (empty($name) || empty($email) || empty($message)) {
            return new WP_Error('missing_fields', 'Please provide all required fields', array('status' => 400));
        }

        $data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message
        );

        $result = $this->db_handler->insert_data($data);

        if ($result) {
            return new WP_REST_Response(array('message' => 'Data inserted successfully'), 201);
        } else {
            return new WP_Error('insert_failed', 'Failed to insert data', array('status' => 500));
        }
    }

    public function get_data_permissions_check($request)
    {
        // Add any permission checks for GET requests here
        return true;
    }

    public function insert_data_permissions_check($request)
    {
        // Add any permission checks for POST requests here
        return current_user_can('edit_posts');
    }
}
