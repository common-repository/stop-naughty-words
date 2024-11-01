<?php

/*
Plugin Name: Stop Naughty Words
Plugin URI: https://vietdex.net/
Description: This plugin will help you remove all naughty words as you want in comment, content, base on your setting. It's also remove all the words that you do not want to display.
Author: Vietnam Indexing
Version: 1.0
Tags: naughty words, remove stop words, remove naughty words, remove words, remove stop words, naughty, content, comment
Author URI: https://vietdex.net/
Donate link: https://vietdex.net/
*/


add_action( 'admin_menu', 'vd_ntw_plugin_menu' );

function vd_ntw_plugin_menu() {
	add_options_page(
		'Naughty Words Options',
		'Naughty Words Setting',
		'manage_options',
		'Naughty-Words.php',
		'NaughtyWordsSetting'
	);
}


function NaughtyWordsSetting() {

	// save setting
	if ( isset ( $_POST['naughty_words'] ) ) {
		update_option('naughty_words', htmlentities($_POST['naughty_words']) );
		update_option('remove_naughty_words_with', sanitize_text_field($_POST['remove_naughty_words_with']));
		update_option('remove_naughty_words_in_comment', sanitize_text_field($_POST['remove_naughty_words_in_comment']));
		update_option('remove_naughty_words_in_content', sanitize_text_field($_POST['remove_naughty_words_in_content']));
	}
	?>
<div class="wrap">
	<h1>Remove Naught Words Setting</h1>
	<p>
	* Here you can set what to replace and in where the naughty words will be replaced
	<br>
	* Remember, this plugin replace words after it saved in database, disable this plugin will not effect all content and comment ! All the naughty words will appear as you want !
	</p>

	<form action="" method="post" name="remove_naughty_words_setting">
	<table class="form-table">
		<tr>
			<th scope="row">List of naughty words:</th>
			<td>
				<label>
					<textarea name="naughty_words" class="large-text"><?php echo get_option('naughty_words') ?></textarea>
				</label>
				<p>* One word per line</p>
			</td>
		</tr>
		<tr>
			<th scope="row">Remove naughty Words with:</th>
			<td>
				<label>
					<input name="remove_naughty_words_with" placeholder="****" class="regular-text" type="text" value="<?php echo get_option('remove_naughty_words_with')?>">
				</label>
				<p>* All naughty words will be removed with this word, eg: fuck => f***</p>
			</td>
		</tr>
		<tr>
			<th scope="row">Options:</th>
			<td>
				<label>
					<input name="remove_naughty_words_in_comment" value="1" type="checkbox" <?php checked(1, get_option('remove_naughty_words_in_comment')) ?>> Remove Naughty Words in Comments
				</label>
				<br>
				<label>
					<input name="remove_naughty_words_in_content" value="1" type="checkbox" <?php checked(1, get_option('remove_naughty_words_in_content')) ?>> Remove Naughty Words in Content
				</label>
			</td>
		</tr>
	</table>
		<p class="submit">
			<input name="submit" id="submit" class="button button-primary" value="Lưu thay đổi" type="submit">
		</p>
	</form>
</div>
	<?php
}


add_filter('the_content', 'vd_naughty_words_content');
add_filter('comment_text', 'vd_naughty_words_comment');
function vd_naughty_words_content($text) {
	if ( get_option('remove_naughty_words_in_content')) {

		$naughty_words = get_option('naughty_words');
		$replace_with = get_option('remove_naughty_words_with');

		$array = explode( "\n", $naughty_words );
		$array = array_map('trim', $array);
		$text = str_replace( $array, $replace_with, $text);

	}

	return $text;
}

function vd_naughty_words_comment($text) {
	if ( get_option('remove_naughty_words_in_comment')) {

		$naughty_words = get_option('naughty_words');
		$replace_with = get_option('remove_naughty_words_with');

		$array = explode( "\n", $naughty_words );
		$array = array_map('trim', $array);
		$text = str_replace( $array, $replace_with, $text);

	}

	return $text;
}
