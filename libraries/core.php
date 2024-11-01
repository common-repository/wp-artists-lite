<?php 
include('lib.shortcodes.php');
include('lib.form.php');
include('lib.functions.php');
include('lib.posttype.php');

include('lib.metabox.php');
include('lib.widgets.php');
//Create Admin Menu
add_action('admin_menu', 'create_wpartist_admin_menu');

function create_wpartist_admin_menu() {
   add_menu_page('WP Artists', 'WPArtists', 'manage_options', 'wpartist_admin', 'wpartists_settings_page');
   add_submenu_page( 'wpartist_admin', 'Settings', 'Settings', 'manage_options', 'wpartists_settings', 'wpartists_settings_page');
   add_submenu_page( 'wpartist_admin', 'Premium', 'Premium', 'manage_options', 'wpartists_preimum', 'wpartists_preimum_page');
}

function wpartists_preimum_page(){ ?>
<div class="wrap">
	<div class="item-description" itemprop="description">
<h3>Features:</h3>
<ul>
<li>3 Widgets + option of requesting new widgets</li>
<li>Fluid CSS/Reponsive Build</li>
<li>Ajax page load on artist page</li>
<li>Custom Page Creation</li>
<li>..and more</li>
</ul>

	<p>WP Artists includes the following areas to manage</p>


<h3>Artists Management</h3>
<img src="http://demo.b4ucode.com/wpartist/wp-content/uploads/2012/11/screenshot_music_admin.jpg">
<p>Manage Artists Profiles with just a few clicks. It’s a simple step to add the Artists’ Biography, main image, Facebook, Twitter links and more.</p>

<h3>Discography Management</h3>

	<p>Create a log of all the Albums, EP’s, LP’s, Mixtapes and Singles of each artists in the system. You can add both back and front cover, description and links to purchase.</p>


<h3>Video Management</h3>
<img src="http://demo.b4ucode.com/wpartist/wp-content/uploads/2012/11/screenshot_video_admin.jpg">
<p>Using WP Artist Manager, you can add a list of videos for each artist and have thumbnails automatically grabbed and displayed.</p>
<h3>Custom Page Management</h3>

<p>Using the plugin you can create unlimited extra pages. So now you can create a page, link it to an artist and embed a Contact Form, Testimonials, Store or more.</p>

<h3>Photo/Gallery Management</h3>

	<p>Photos are very important and for any manager, uploading photos should be quick and simple. Creating a photo gallery is as simple as adding images to posts.</p>


<h3>Events/Tour Management</h3>

	<p>WP Artists, provides a simple way to add events for each artist. Whether it is a concert or radio interview time, you can use the Events Manager to spread the word.</p>


<h3>Links Management</h3>

	<p>Last but not least, is Links Management. This area of the system allows you to add relevant links to each artist. For instance, myspace, twitter, sponsors etc….</p>


	<p><img src="http://demo.b4ucode.com/wpartist/wp-content/uploads/2012/11/widget.jpg">
</p>

    </div>
</div>
<?php
}
function wpartists_settings_page()
{
	?>

<div class="wrap">
  <?php
global $blog_id;
if( isset( $_POST['wpa_settings_save'] )  || wp_verify_nonce($_POST['wpa_artist_nonce'],'wpa_artist_nonce') )
{
update_option( 'wpa_edit_page_id' , (int) $_POST[ 'wpa_edit_page_id' ] );
update_option( 'wpa_dashboard_page_id' , (int) $_POST[ 'wpa_dashboard_page_id' ] );
update_option( 'wpa_enable_frontend' , (int) $_POST[ 'wpa_enable_frontend' ] );
update_option( 'wpa_show_fb' , (int)$_POST[ 'wpa_show_fb' ] );
update_option( 'wpa_show_tw' , (int)$_POST[ 'wpa_show_tw' ] );
}
$wpa_sc_count	= get_option('wpa_sc_count');
if(empty($wpa_sc_count)){$wpa_sc_count = 4;}
$wpa_enable_frontend = get_option('wpa_enable_frontend');
?>
  <div id="settingsform">
    <form id='wpa_settings_form' method="post" action="">
      <h1><?php echo 'WP Artist Settings'; ?></h1>
      <table class="form-table">
        <tr valign="top">
          <th scope="row"><label for="blogname">
            <?php _e('Front-end Submission') ?>
            </label></th>
          <td><select name="wpa_enable_frontend" disabled="disabled">
              <option value="1" <?php if($wpa_enable_frontend == 1){echo 'selected="selected"';}?>>Yes</option>
              <option value="0" <?php if($wpa_enable_frontend == 0){echo 'selected="selected"';}?>>No</option>
            </select> <span class="premium_only">Available in Premium</span>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="blogdescription">
            <?php _e('Show Facebook Button') ?>
            </label></th>
          <td> Show&nbsp;
            <input name="wpa_show_fb" type="radio" value="0" <?php checked( '0', get_option( 'wpa_show_fb' ) ); ?> />
            Hide&nbsp;
            <input name="wpa_show_fb" type="radio" value="1" <?php checked( '1', get_option( 'wpa_show_fb' ) ); ?> />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="blogdescription">
            <?php _e('Show Twitter Button') ?>
            </label></th>
          <td> Show&nbsp;
            <input name="wpa_show_tw" type="radio" value="0" <?php checked( '0', get_option( 'wpa_show_tw' ) ); ?> />
            Hide&nbsp;
            <input name="wpa_show_tw" type="radio" value="1" <?php checked( '1', get_option( 'wpa_show_tw' ) ); ?> />
          </td>
        </tr>
        <tr>
          <td colspan="2"><div class="description">Thank you for using WP Artist, for support please e-mail <a href="http://b4ucode.com/contact-us.html" target="_blank">B4uCode</a>.
          <br />
	This plugin has a premium version, that I encourage you to look at if you would like some extended features. <a href="http://codecanyon.net/item/wordpress-artist-band-manager/3516528" target="_blank">WP Artists Premium</a><br />
              You can show your support by leaving a comment/rating on  or following B4uCode on <a href="http://www.twitter.com/b4ucode" target="_blank">Twitter</a> or <a href="http://www.facebook.com/b4ucode" target="_blank">Facebook</a>             
              
              </div></td>
        </tr>
      </table>
      <?php echo wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce'); ?>
      <p class="submit">
        <input type="submit" id="wpa_settings_save" name="wpa_settings_save" class="button-primary" value="<?php echo 'Save'; ?>" />
      </p>
    </form>
  </div>
</div>
<?php }

?>
