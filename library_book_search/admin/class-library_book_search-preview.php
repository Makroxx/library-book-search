<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Library_book_search
 * @subpackage Library_book_search/admin
 */

/**
* Create Book shortcode preview page
*/
class Bookshortcodepreviewpage extends Library_book_search_Admin
{
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function library_book_search_preview(){
		?>
		<div class="wrap">
			<h1>Library Book Search Shortcode </h1>
			<div>
				<label>Shortcode :</label> <input type="text" readonly="" value="[library_book_search]">
			</div>
		</div>
		<hr>
		<div class="wrap">
			<?php
			if(isset($_POST) && !empty($_POST['perpagebook'])){
				update_option( "perpagebook", $_POST['perpagebook'], "5" );
			}
			?>
			<form action="" method="post" name="save_perpagebook">
				<?php
				$perpagebook = get_option( "perpagebook" );
				?>
				<label>Per Page Books:</label> <input type="number" name="perpagebook"  min="5" max="20" value="<?php echo $perpagebook; ?>">
				<input type="submit" name="Save" value="Save" class="button button-primary button-large">
			</form>
		</div>
		<?php
	}
}