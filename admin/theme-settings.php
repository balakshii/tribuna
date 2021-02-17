<?php
// create custom plugin settings menu
add_action('admin_menu', 'tribuna_create_menu');

function tribuna_create_menu() {

	//create new top-level menu
	add_menu_page('TribunaSettings', 'Tribuna Settings', 'administrator', __FILE__, 'tribuna_settings_page', get_bloginfo('template_url').'/admin/icon-small.png');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}

add_filter( 'baw_count_views_count', 'theme_customCounter', 1 );
function theme_customCounter( $count )
{
	$multiplier = get_option('view_multiplier');
    if (empty($multiplier)) return $count;

    return ($count * $multiplier);
}

function register_mysettings() {
	register_setting( 'baw-settings-group', 'view_multiplier' );
}

function tribuna_settings_page() {
?>
<div class="wrap">
<h2>Tribuna Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Умножитель просмотров</th>
            <td><input type="text" name="view_multiplier" value="<?php echo get_option('view_multiplier'); ?>" /></td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>