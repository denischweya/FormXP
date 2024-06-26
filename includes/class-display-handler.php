<?php
class Display_Handler
{
    private $db_handler;

    public function __construct($db_handler)
    {
        $this->db_handler = $db_handler;
    }

    public function render_data()
    {
        $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
        $data = $this->db_handler->get_data($search);

        ob_start();
        ?>
<div class="custom-data-display">
    <form method="get">
        <input type="text" name="search" placeholder="Search"
            value="<?php echo esc_attr($search); ?>">
        <button type="submit">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo esc_html($row->name); ?></td>
                <td><?php echo esc_html($row->email); ?></td>
                <td><?php echo esc_html($row->message); ?></td>
                <td><?php echo esc_html($row->created_at); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
        return ob_get_clean();
    }
}
