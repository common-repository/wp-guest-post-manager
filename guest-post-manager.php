<?php
/**
* Plugin Name: Guest Post Manager
* Plugin URI: https://guestpostplugin.com
* Description: Organize, Track and Manage Your Sponsored Content & Guest Posts
* Author: guestpostplugin
* Author URI: https://guestpostplugin.com/
* Text Domain: guest-post-manager
* Version: 1.1.3
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
**/


if (! defined('ABSPATH')) {
    die();
}

if (! defined('GPMGR_PLUG_FILE')) {
    define('GPMGR_PLUG_FILE', __FILE__);
}

/**
*  Create metabox to show in Posts
**/
function gpmgr_add()
{
    add_meta_box(
        'gpmgr_m_b',
        'Save Guest Post Info',
        'gpmgr_content_fn',
        'post',
        'side',
        'default'
    );
}

/**
*  This function will render the HTML for the medtabox 'gpmgr_m_b'
*
*  @param	N/A
*  @return	N/A
**/

function gpmgr_content_fn($p)
{
    $gpmgr_options = get_option('gpmgr_options');
    $post_payment_status = (get_post_meta($p->ID, 'gpmgr_post_payment_status', true) == "") ? "Pending" : get_post_meta($p->ID, 'gpmgr_post_payment_status', true); 
    $symbol = gpmgr_get_currency_symbols($gpmgr_options['gpmgr_currency_country']);
    ?>
<div class="guest-post-manager-meta-box">
  <?php
    wp_nonce_field(basename(__FILE__), 'gpmgr_post_nonce'); ?>
  <p>
    <label for="gpmgr_post_enabled"><?php _e("Enable", 'guest-post-manager'); ?></label>
    <br />
    <input type="radio" name="gpmgr_post_enabled" value="yes" <?php checked(get_post_meta($p->ID, 'gpmgr_post_enabled', true), 'yes'); ?>>Yes
    <input type="radio" name="gpmgr_post_enabled" value="no" <?php checked(get_post_meta($p->ID, 'gpmgr_post_enabled', true), 'no'); ?>>No
  </p>

  <p>
    <label for="gpmgr_post_name"><?php _e("Name", 'guest-post-manager'); ?></label><br />
    <input type="text" name="gpmgr_post_name" id="gpmgr_post_name" value="<?php echo esc_attr(get_post_meta($p->ID, 'gpmgr_post_name', true)); ?>" />
  </p>

  <p>
    <label for="gpmgr_post_type"><?php _e("Post Type", 'guest-post-manager'); ?></label><br />
    <input type="radio" name="gpmgr_post_type" value="paid" <?php checked(get_post_meta($p->ID, 'gpmgr_post_type', true), 'paid'); ?>
    <?php echo((get_post_meta($p->ID, 'gpmgr_post_type', true) ==  "") ? "checked='checked'" : ""); ?>>PAID
    <input type="radio" name="gpmgr_post_type" value="free" <?php checked(get_post_meta($p->ID, 'gpmgr_post_type', true), 'free'); ?>>FREE
  </p>
<div id="gpmgr-price-section"  <?php echo(get_post_meta($p->ID, 'gpmgr_post_type', true) ==  "" || get_post_meta($p->ID, 'gpmgr_post_type', true) == "paid") ? "style='display:block'" : ""; ?>>
  <p>
    <label for="gpmgr_post_price"><?php _e("Price", 'guest-post-manager'); ?></label>
    <br />
    <span><strong><?php echo $symbol; ?></strong></span>
    <input type="number" name="gpmgr_post_price" id="gpmgr_post_price" step="any"  value="<?php echo esc_attr(get_post_meta($p->ID, 'gpmgr_post_price', true)); ?>" size="8" />
  </p>

  <p>
    <label for="gpmgr_post_email"><?php _e("Client Email", 'guest-post-manager'); ?></label><br />
    <input type="email" name="gpmgr_post_email" id="gpmgr_post_email" value="<?php echo esc_attr(get_post_meta($p->ID, 'gpmgr_post_email', true)); ?>" />
  </p>
</div>
  <p>
    <label for="gpmgr_post_due_date"><?php _e("Payment Due Date", 'guest-post-manager'); ?></label><span class="gpmgr-due-date-inner"></span><br />
    <input type="text" name="gpmgr_post_due_date" id="gpmgr_post_due_date" value="<?php echo esc_attr(get_post_meta($p->ID, 'gpmgr_post_due_date', true)); ?>" size="7" />
  </p>

  <p>
    <label for="gpmgr_post_payment_status"><?php _e("Payment Status", 'guest-post-manager'); ?></label><br />
    <input type="radio" name="gpmgr_post_payment_status" value="Pending" <?php checked(get_post_meta($p->ID, 'gpmgr_post_payment_status', true), 'Pending'); ?> <?php echo (get_post_meta($p->ID, 'gpmgr_post_payment_status', true) ==  "") ? "checked='checked'" : ""; ?>>UNPAID
  	<input type="radio" name="gpmgr_post_payment_status" value="Completed" <?php checked(get_post_meta($p->ID, 'gpmgr_post_payment_status', true), 'Completed'); ?>>PAID

  </p>

  <p>
    <input type="checkbox" style="" id="gpmgr_post_sponsored" name="gpmgr_post_sponsored" value="yes" <?php checked(get_post_meta($p->ID, 'gpmgr_post_sponsored', true), 'yes'); ?>>
    <label for="gpmgr_post_sponsored"><?php _e("Mark as Sponsored", 'guest-post-manager'); ?></label>

    <div id="gpmgr-post-sponsored-edit-screen">
      <p><label for="gpmgr_post_sponsored_position"><?php _e("Text Position", 'guest-post-manager'); ?></label><br />
      <select name="gpmgr_post_sponsored_position" id="gpmgr_post_sponsored_position">
        <option value='above' <?php selected(gpmgr_get_post_sponsored_position(), 'Above Content'); ?>><?php _e("Above Content", 'guest-post-manager'); ?></option>
        <option value='below' <?php selected(gpmgr_get_post_sponsored_position(), 'Below Content'); ?>><?php _e("Below Content", 'guest-post-manager'); ?></option>
      </select></p>
      <p><label for="gpmgr_post_sponsored_content" class="post-attributes-label"><?php _e("Text to dislay", 'guest-post-manager'); ?></label></p>
      <textarea name="gpmgr_post_sponsored_content" rows="4" cols="30"><?php echo esc_textarea(get_post_meta($p->ID, 'gpmgr_post_sponsored_content', true)); ?></textarea>
    </div>
  </p>

</div>
<?php
}

/**
*  Show sponsored content above or below post
*
*  @param	string $content
*  @return string
**/
function gpmgr_post_sponsored_filter($content)
{
    global $post;
    if (is_single() && 'post' == get_post_type()) {
        $gpmgr_post_sponsored = get_post_meta($post->ID, 'gpmgr_post_sponsored', true);
        $gpmgr_post_sponsored_position = get_post_meta($post->ID, 'gpmgr_post_sponsored_position', true);
        $gpmgr_post_sponsored_content = "<p>" . esc_html(get_post_meta($post->ID, 'gpmgr_post_sponsored_content', true))."</p>";
        if ($gpmgr_post_sponsored == "yes") {
            if ($gpmgr_post_sponsored_position == "below") {
                return $content . $gpmgr_post_sponsored_content;
            } else {
                return $gpmgr_post_sponsored_content . $content;
            }
        }
    }
    return $content;
}


/**
* get the position of sponsored content
*
*@return string
**/
function gpmgr_get_post_sponsored_position()
{
    global $post;
    $return = '';
    $status = get_post_meta($post->ID, 'gpmgr_post_sponsored_position', true);
    switch ($status) {
      case 'above':
        $return = "Above Content";
        break;
      case 'below':
        $return = "Below Content";
        break;
      default:
        $return = "Below Content";
        break;
    }
    return $return;
}

/**
* Save metadata
*
* @param int $post_id
* @param array $post
*
* @return void
**/
function gpmgr_save($post_id, $post)
{
    /* Verify the nonce before proceeding. */
    $gpmgr_post_nonce = isset($_POST['gpmgr_post_nonce']) ? sanitize_text_field($_POST['gpmgr_post_nonce']) : '';
    if (!isset($gpmgr_post_nonce) || !wp_verify_nonce($gpmgr_post_nonce, basename(__FILE__))) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
        return $post_id;
    }

    //Enabled
    $gpmgr_post_enabled = sanitize_text_field($_POST['gpmgr_post_enabled']);
    if (isset($gpmgr_post_enabled)) {
        update_post_meta($post_id, 'gpmgr_post_enabled', $gpmgr_post_enabled);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_enabled');
    }

    //POST Name
    $gpmgr_post_name = sanitize_text_field($_POST['gpmgr_post_name']);
    if (isset($gpmgr_post_name)) {
        update_post_meta($post_id, 'gpmgr_post_name', $gpmgr_post_name);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_name');
    }

    //POST Email
    $gpmgr_post_email = sanitize_email($_POST['gpmgr_post_email']);
    if (isset($gpmgr_post_email)) {
        update_post_meta($post_id, 'gpmgr_post_email', $gpmgr_post_email);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_email');
    }

    //POST Post Type
    $gpmgr_post_type = sanitize_text_field($_POST['gpmgr_post_type']);
    if (isset($gpmgr_post_type)) {
        update_post_meta($post_id, 'gpmgr_post_type', $gpmgr_post_type);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_type');
    }

    //POST Price
    $gpmgr_post_price = sanitize_text_field($_POST['gpmgr_post_price']);
    if (isset($gpmgr_post_price)) {
        update_post_meta($post_id, 'gpmgr_post_price', $gpmgr_post_price);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_price');
    }

    //POST Payment Due Date
    $gpmgr_post_due_date = sanitize_text_field($_POST['gpmgr_post_due_date']);
    if (isset($gpmgr_post_due_date)) {
        update_post_meta($post_id, 'gpmgr_post_due_date', $gpmgr_post_due_date);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_due_date');
    }

    //POST PAYMENT STATUS
    $gpmgr_post_payment_status = sanitize_text_field($_POST['gpmgr_post_payment_status']);
    if (isset($gpmgr_post_payment_status)  && !empty($gpmgr_post_payment_status)) {
        update_post_meta($post_id, 'gpmgr_post_payment_status', $gpmgr_post_payment_status);
    } else {
        update_post_meta($post_id, 'gpmgr_post_payment_status', 'Pending');
    }

    //POST Sponsored
    $gpmgr_post_sponsored = (isset($_POST['gpmgr_post_sponsored']) ? sanitize_text_field($_POST['gpmgr_post_sponsored'])  : '');
    if (isset($gpmgr_post_sponsored)  && !empty($gpmgr_post_sponsored)) {
        update_post_meta($post_id, 'gpmgr_post_sponsored', $gpmgr_post_sponsored);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_sponsored');
    }
    //POST Sponsored content position
    $gpmgr_post_sponsored_position = sanitize_text_field($_POST['gpmgr_post_sponsored_position']);
    if (isset($gpmgr_post_sponsored_position)  && !empty($gpmgr_post_sponsored_position)) {
        update_post_meta($post_id, 'gpmgr_post_sponsored_position', $gpmgr_post_sponsored_position);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_sponsored_position');
    }

    //POST Sponsored Content
    $gpmgr_post_sponsored_content = sanitize_textarea_field($_POST['gpmgr_post_sponsored_content']);
    if (isset($gpmgr_post_sponsored_content)  && !empty($gpmgr_post_sponsored_content)) {
        update_post_meta($post_id, 'gpmgr_post_sponsored_content', $gpmgr_post_sponsored_content);
    } else {
        delete_post_meta($post_id, 'gpmgr_post_sponsored_content');
    }
}

/**
* Enqueue admin script and styles
*
* @return void
**/
function gpmgr_meta_box_scripts($hook)
{
    $screen = get_current_screen();
    if (is_object($screen)) {
        if ($screen->post_type == 'post') {
            wp_enqueue_script('gpmgr-post-meta-box-script', plugin_dir_url(__FILE__) . 'js/admin.js', array( 'jquery' ));
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_style('gpmgr-post-meta-box-style', plugin_dir_url(__FILE__) . 'css/admin.css');
            wp_enqueue_style('gpmgr-jquery-ui-css', plugin_dir_url(__FILE__) . 'css/jquery-ui.css');
        }
    }
   
    if ( 'toplevel_page_guest-post-manager' == $hook ) {
        wp_enqueue_style('gpmgr-post-meta-box-style', plugin_dir_url(__FILE__) . 'css/admin.css');
    }
    
}

/**
* edit post lists page
*
* @return void
**/
function gpmgr_query_add_filter_main($wp_query)
{
    if (is_admin()) {
        add_filter('views_edit-post', 'gpmgr_filter_posts');
    }
}

/**
* edit post lists page
*
* @return void
**/
function gpmgr_query_add_filter_pd($wp_query)
{
    if (is_admin()) {
        add_filter('views_edit-post', 'gpmgr_filter_postsfn_pd');
    }
}

/**
* edit post lists page function
*
* @return array
**/
function gpmgr_filter_posts($views)
{
    global $wp_query, $wpdb;
    $class = ' ';
    if (isset($wp_query->query_vars['meta_query'])) {
        foreach ($wp_query->query_vars['meta_query'] as $key) {
            if (isset($key['key'])) {
                if ($key['key'] == "gpmgr_post_enabled") {
                    $class = ' class="current"';
                }
            }
        }
    }
    $found_posts = $wpdb->get_var(
        $wpdb->prepare(
            'SELECT COUNT( 1 )
				FROM ' . $wpdb->postmeta . '
				WHERE post_id IN( SELECT ID FROM ' . $wpdb->posts . ' WHERE post_type = %s AND post_status != "trash" ) &&
				meta_value = "yes" AND meta_key = %s
				',
            'post',
            'gpmgr_post_enabled'
        )
    );
    $views['guest_posts'] = sprintf(
        __('<a href="%s"'. $class .'>Guest Posts <span class="count">(%d)</span></a>', ''),
        admin_url('edit.php?post_type=post&guest_posts=1'),
        $found_posts
    );

    return $views;
}

/**
* edit post lists page function
*
* @return array
**/
function gpmgr_filter_postsfn_pd($views)
{
    global $wpdb;
    //  AND ({$wpdb->prefix}posts.post_status = 'publish')
    $found_posts = $wpdb->get_var(
        "SELECT  count(*)  FROM {$wpdb->prefix}posts
      INNER JOIN {$wpdb->prefix}postmeta j1 ON ({$wpdb->prefix}posts.ID = j1.post_id)
      INNER JOIN {$wpdb->prefix}postmeta j2 ON ({$wpdb->prefix}posts.ID = j2.post_id)

      WHERE 1=1
      AND {$wpdb->prefix}posts.post_type = 'post'
	  AND {$wpdb->prefix}posts.post_status != 'trash'
      AND ( j1.meta_key = 'gpmgr_post_enabled' AND j1.meta_value = 'yes'  )
      AND ( j2.meta_key = 'gpmgr_post_payment_status' AND j2.meta_value = 'Pending'  )

      "
    );
    $class = ' ';
    $payment_due = filter_input(INPUT_GET, 'payment_due', FILTER_SANITIZE_NUMBER_INT);
    if (isset($payment_due) && $payment_due == 1) {
        $class = ' class="current"';
    }
    $views['payment_due'] = sprintf(
        __('<a href="%s"'. $class .'>Guest Payments Due <span class="count">(%d)</span></a>', ''),
        admin_url('edit.php?post_type=post&payment_due=1'),
        $found_posts
    );
    return $views;
}

/**
* post filter query
*
* @return void
**/
function gpmgr_guest_posts_filter_main($query)
{
    if (isset($query->query['post_type'])) {
        if (is_admin() and $query->query['post_type'] == 'post') {
            if (gpmgr_is_filter_active()) {
                $qv = &$query->query_vars;
                $qv['meta_query'] = array(
          array(
           'key' => 'gpmgr_post_enabled',
           'value' => 'yes'
         )
       );
            }
        }
    }
}

/**
* post filter query
*
* @return void
**/
function gpmgr_guest_posts_filter_pd($query)
{
    if (is_admin() and $query->query['post_type'] == 'post') {
        $payment_due = filter_input(INPUT_GET, 'payment_due', FILTER_SANITIZE_NUMBER_INT);
        if (isset($payment_due) && $payment_due == 1) {
            $qv = &$query->query_vars;
            $qv['meta_query'] = array(
          array(
            'relation' => 'AND',
            array(
                'key' => 'gpmgr_post_enabled',
                'value' => 'yes',
            ),
            array(
                'key' => 'gpmgr_post_payment_status',
                'value' => 'Pending',
            )
        )
        );
        }
    }
}

/**
* admin filter hooks
*
* @return void
**/
function gpmgr_checkis_admin()
{
    if (! is_user_logged_in()) {
        return ;
    }
    if (! current_user_can('manage_options')) {
        return ;
    }
    add_action('pre_get_posts', 'gpmgr_query_add_filter_main');
    add_action('pre_get_posts', 'gpmgr_query_add_filter_pd');
    add_filter('parse_query', 'gpmgr_guest_posts_filter_main');
    add_filter('parse_query', 'gpmgr_guest_posts_filter_pd');

    add_action('admin_enqueue_scripts', 'gpmgr_meta_box_scripts');
    add_action('add_meta_boxes', 'gpmgr_add');
    add_action('save_post', 'gpmgr_save', 10, 2);
}

/**
* plugin activation
*
* @return void
**/
function gpmgr_activate()
{
    global $wpdb;
    //Register Settings
    if (false === get_option('gpmgr_options')) {
        $defaults = array(
            'gpmgr_currency_country' => 'USD'
        );
        add_option('gpmgr_options', $defaults);
    }
}


/**
* plugin deactivation
*
* @return void
**/
function gpmgr_deactivate()
{
}

/**
* SHOW Column on posts page
*
* @return array
**/
function gpmgr_set_custom_edit_book_columns($columns)
{
    if (gpmgr_is_filter_active()) {
        $columns['gpmgr_post_name'] = __('Clients', 'guest-post-manager');
        $columns['gpmgr_post_due_date'] = __('Due Date', 'guest-post-manager');
    }
    return $columns;
}


/**
* custom column
*
* @return string
**/
function gpmgr_custom_column($column, $post_id)
{
    if (gpmgr_is_filter_active()) {
        switch ($column) {
            case 'gpmgr_post_name':
                echo get_post_meta($post_id, 'gpmgr_post_name', true);
                break;
            case 'gpmgr_post_due_date':
                echo date("F j, Y", strtotime(get_post_meta($post_id, 'gpmgr_post_due_date', true)));
                break;

          }
    }
}

/**
* check the current tab on post list page
*
* @return boolean
**/
function gpmgr_is_filter_active()
{
    return (filter_input(INPUT_GET, 'guest_posts', FILTER_SANITIZE_NUMBER_INT) == 1 || filter_input(INPUT_GET, 'payment_due', FILTER_SANITIZE_NUMBER_INT) == 1);
}

add_action('init', 'gpmgr_checkis_admin');
add_filter('the_content', 'gpmgr_post_sponsored_filter');
register_activation_hook(__FILE__, 'gpmgr_activate');
register_deactivation_hook(__FILE__, 'gpmgr_deactivate');
add_filter('manage_posts_columns', 'gpmgr_set_custom_edit_book_columns');
add_action('manage_posts_custom_column', 'gpmgr_custom_column', 10, 2);
require_once dirname(GPMGR_PLUG_FILE) . '/admin/gpmgr-settings-general.php';
require_once dirname(GPMGR_PLUG_FILE) . '/admin/gpmgr-settings.php';