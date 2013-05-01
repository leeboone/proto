<?php

///////////////////////////////////////////////
//Theme Options
///////////////////////////////////////////////
if ( ! function_exists( 'add_theme_options' ) ) :
function add_theme_options(){
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' ); 


function theme_options_init(){
 register_setting( 'options_group', 'theme_options');
} 

function theme_options_add_page() {
 add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

function theme_options_do_page() { 
    global $select_options; 
    if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false; ?>
    
    <div>
    
    <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
    <div>
    <p><strong><?php echo 'Options Saved'; ?></strong></p></div>
    
    <?php endif; ?> 
    <form method="post" action="options.php">
    <?php settings_fields( 'options_group' ); ?>  
    
    <?php $options = get_option( 'theme_options' ); ?> 
    <table cellpadding="10">
    <tr>
        <th colspan="2" style="font-size:21px;font-weight:normal;text-align:left; padding:10px 0;">Theme Options</th>
    </tr>

    <tr valign="top"><th scope="row">Physical Address</th>
    <td valign="top">
    <p style="margin-top:0;"><em>Street Name St., Wherever, XX 00001</em></p>
    <textarea id="theme_options[physicaladdress]"
    class="large-text" cols="50" rows="10" name="theme_options[physicaladdress]"><?php echo esc_textarea( $options[physicaladdress] ); ?></textarea>
    </td>
    </tr>

    <tr valign="top"><th scope="row">Phone</th>
    <td valign="top">
    <p style="margin-top:0;"><em>555-555-5555</em></p>
    <textarea id="theme_options[phone]"
    class="large-text" cols="50" rows="10" name="theme_options[phone]"><?php echo esc_textarea( $options[phone] ); ?></textarea>
    </td>
    </tr>

    <tr valign="top"><th scope="row">Fax</th>
    <td valign="top">
    <p style="margin-top:0;"><em>555-555-5555</em></p>
    <textarea id="theme_options[fax]"
    class="large-text" cols="50" rows="10" name="theme_options[fax]"><?php echo esc_textarea( $options[fax] ); ?></textarea>
    </td>
    </tr>

    <tr valign="top"><th scope="row">Email</th>
    <td valign="top">
    <p style="margin-top:0;"><em>name@domain.com</em></p>
    <textarea id="theme_options[email]"
    class="large-text" cols="50" rows="10" name="theme_options[email]"><?php echo esc_textarea( $options[email] ); ?></textarea>
    </td>
    </tr>

    <tr valign="top"><th scope="row">Copyright Line</th>
    <td valign="top">
    <p style="margin-top:0;">Text Displays after <strong>&copy;<?php echo date('Y'); ?></em></strong> In the website Footer</p>
    <textarea id="theme_options[copyrightline]"
    class="large-text" cols="50" rows="10" name="theme_options[copyrightline]"><?php echo esc_textarea( $options[copyrightline] ); ?></textarea>
    </td>
    </tr>

    </table>


    <p>
    <input type="submit" value="<?php echo 'Save Options'; ?>" />
    </p>
    </form>
    </div>
<?php } 
}
add_theme_options();
endif;



///////////////////////////////////////////////////////
//REBRAND WP LOGIN
///////////////////////////////////////////////////////
if ( ! function_exists( 'admin_rebrand' ) ) :
function admin_rebrand(){
function my_custom_login() {
 echo "<link rel='stylesheet' type='text/css' href='" . get_bloginfo("template_directory") . "/css/admin_css.css' />";
 }
 add_action("login_head", "my_custom_login");
 add_action("admin_head", "my_custom_login");


/**REPLACE FOOTER TEXT**/
 function filter_footer_admin() { ?>
 site created by <a href='http://leeboone.com/'>Lee Boone Design</a>
 <?php }

 add_filter("admin_footer_text", "filter_footer_admin");
}
admin_rebrand();
endif;

