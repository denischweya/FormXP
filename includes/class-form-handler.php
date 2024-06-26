<?php
class Form_Handler
{
    private $db_handler;

    public function __construct($db_handler)
    {
        $this->db_handler = $db_handler;
        add_action('wp_ajax_submit_custom_form', array($this, 'handle_form_submission'));
        add_action('wp_ajax_nopriv_submit_custom_form', array($this, 'handle_form_submission'));
    }

    public function render_form()
    {
        ob_start();
        ?>
<form id="custom-form">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <textarea name="message" placeholder="Message" required></textarea>
    <button type="submit">Submit</button>
</form>
<div id="form-message"></div>
<?php
        return ob_get_clean();
    }

    public function handle_form_submission()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'custom_form_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        $data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message
        );

        $result = $this->db_handler->insert_data($data);

        if ($result) {
            wp_send_json_success('Data submitted successfully');
        } else {
            wp_send_json_error('Error submitting data');
        }
    }
}
