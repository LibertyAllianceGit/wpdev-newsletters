<?php
/**
Add Template
**/
function wpdevnews_base_register_page_template( $templates ){
	$templates['templates/email-builder.php'] = 'Email Builder';
	return $templates;
}
add_filter( 'theme_page_templates', 'wpdevnews_base_register_page_template' );

/**
Create Email Builder Meta Box
**/
function newsletter_settings_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function newsletter_settings_add_meta_box() {
	add_meta_box(
		'newsletter_settings-newsletter-settings',
		__( 'Newsletter Settings', 'newsletter_settings' ),
		'newsletter_settings_html',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'newsletter_settings_add_meta_box' );

function newsletter_settings_html( $post) {
	wp_nonce_field( '_newsletter_settings_nonce', 'newsletter_settings_nonce' ); ?>

	<p>Set the global settings for the email newsletter.</p>

	<p>
		<label for="newsletter_settings_logo"><?php _e( 'Logo', 'newsletter_settings' ); ?></label><br>
		<input type="text" name="newsletter_settings_logo" id="newsletter_settings_logo" value="<?php echo newsletter_settings_get_meta( 'newsletter_settings_logo' ); ?>">
	</p>	<p>

		<input type="radio" name="newsletter_settings_header_layout" id="newsletter_settings_header_layout_0" value="Left" <?php echo ( newsletter_settings_get_meta( 'newsletter_settings_header_layout' ) === 'Left' ) ? 'checked' : ''; ?>>
<label for="newsletter_settings_header_layout_0">Left</label><br>

		<input type="radio" name="newsletter_settings_header_layout" id="newsletter_settings_header_layout_1" value="Center" <?php echo ( newsletter_settings_get_meta( 'newsletter_settings_header_layout' ) === 'Center' ) ? 'checked' : ''; ?>>
<label for="newsletter_settings_header_layout_1">Center</label><br>

		<input type="radio" name="newsletter_settings_header_layout" id="newsletter_settings_header_layout_2" value="Right" <?php echo ( newsletter_settings_get_meta( 'newsletter_settings_header_layout' ) === 'Right' ) ? 'checked' : ''; ?>>
<label for="newsletter_settings_header_layout_2">Right</label><br>
	</p>	<p>
		<label for="newsletter_settings_social_media_accounts"><?php _e( 'Social Media Accounts', 'newsletter_settings' ); ?></label><br>
		<textarea name="newsletter_settings_social_media_accounts" id="newsletter_settings_social_media_accounts" ><?php echo newsletter_settings_get_meta( 'newsletter_settings_social_media_accounts' ); ?></textarea>
	
	</p>	<p>
		<label for="newsletter_settings_social_media_links"><?php _e( 'Social Media Links', 'newsletter_settings' ); ?></label><br>
		<textarea name="newsletter_settings_social_media_links" id="newsletter_settings_social_media_links" ><?php echo newsletter_settings_get_meta( 'newsletter_settings_social_media_links' ); ?></textarea>
	
	</p>	<p>

		<input type="radio" name="newsletter_settings_footer_layout" id="newsletter_settings_footer_layout_0" value="Full Width" <?php echo ( newsletter_settings_get_meta( 'newsletter_settings_footer_layout' ) === 'Full Width' ) ? 'checked' : ''; ?>>
<label for="newsletter_settings_footer_layout_0">Full Width</label><br>

		<input type="radio" name="newsletter_settings_footer_layout" id="newsletter_settings_footer_layout_1" value="Two Column" <?php echo ( newsletter_settings_get_meta( 'newsletter_settings_footer_layout' ) === 'Two Column' ) ? 'checked' : ''; ?>>
<label for="newsletter_settings_footer_layout_1">Two Column</label><br>
	</p>	<p>
		<label for="newsletter_settings_copyright"><?php _e( 'Copyright', 'newsletter_settings' ); ?></label><br>
		<input type="text" name="newsletter_settings_copyright" id="newsletter_settings_copyright" value="<?php echo newsletter_settings_get_meta( 'newsletter_settings_copyright' ); ?>">
	</p>	<p>
		<label for="newsletter_settings_view_in_browser_link"><?php _e( 'View in Browser Link', 'newsletter_settings' ); ?></label><br>
		<input type="text" name="newsletter_settings_view_in_browser_link" id="newsletter_settings_view_in_browser_link" value="<?php echo newsletter_settings_get_meta( 'newsletter_settings_view_in_browser_link' ); ?>">
	</p>	<p>
		<label for="newsletter_settings_unsubscribe_link"><?php _e( 'Unsubscribe Link', 'newsletter_settings' ); ?></label><br>
		<input type="text" name="newsletter_settings_unsubscribe_link" id="newsletter_settings_unsubscribe_link" value="<?php echo newsletter_settings_get_meta( 'newsletter_settings_unsubscribe_link' ); ?>">
	</p>	<p>
		<label for="newsletter_settings_privacy_policy_link"><?php _e( 'Privacy Policy Link', 'newsletter_settings' ); ?></label><br>
		<input type="text" name="newsletter_settings_privacy_policy_link" id="newsletter_settings_privacy_policy_link" value="<?php echo newsletter_settings_get_meta( 'newsletter_settings_privacy_policy_link' ); ?>">
	</p><?php
}

function newsletter_settings_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['newsletter_settings_nonce'] ) || ! wp_verify_nonce( $_POST['newsletter_settings_nonce'], '_newsletter_settings_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['newsletter_settings_logo'] ) )
		update_post_meta( $post_id, 'newsletter_settings_logo', esc_attr( $_POST['newsletter_settings_logo'] ) );
	if ( isset( $_POST['newsletter_settings_header_layout'] ) )
		update_post_meta( $post_id, 'newsletter_settings_header_layout', esc_attr( $_POST['newsletter_settings_header_layout'] ) );
	if ( isset( $_POST['newsletter_settings_social_media_accounts'] ) )
		update_post_meta( $post_id, 'newsletter_settings_social_media_accounts', esc_attr( $_POST['newsletter_settings_social_media_accounts'] ) );
	if ( isset( $_POST['newsletter_settings_social_media_links'] ) )
		update_post_meta( $post_id, 'newsletter_settings_social_media_links', esc_attr( $_POST['newsletter_settings_social_media_links'] ) );
	if ( isset( $_POST['newsletter_settings_footer_layout'] ) )
		update_post_meta( $post_id, 'newsletter_settings_footer_layout', esc_attr( $_POST['newsletter_settings_footer_layout'] ) );
	if ( isset( $_POST['newsletter_settings_copyright'] ) )
		update_post_meta( $post_id, 'newsletter_settings_copyright', esc_attr( $_POST['newsletter_settings_copyright'] ) );
	if ( isset( $_POST['newsletter_settings_view_in_browser_link'] ) )
		update_post_meta( $post_id, 'newsletter_settings_view_in_browser_link', esc_attr( $_POST['newsletter_settings_view_in_browser_link'] ) );
	if ( isset( $_POST['newsletter_settings_unsubscribe_link'] ) )
		update_post_meta( $post_id, 'newsletter_settings_unsubscribe_link', esc_attr( $_POST['newsletter_settings_unsubscribe_link'] ) );
	if ( isset( $_POST['newsletter_settings_privacy_policy_link'] ) )
		update_post_meta( $post_id, 'newsletter_settings_privacy_policy_link', esc_attr( $_POST['newsletter_settings_privacy_policy_link'] ) );
}
add_action( 'save_post', 'newsletter_settings_save' );

/*
	Usage: newsletter_settings_get_meta( 'newsletter_settings_logo' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_header_layout' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_social_media_accounts' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_social_media_links' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_footer_layout' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_copyright' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_view_in_browser_link' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_unsubscribe_link' )
	Usage: newsletter_settings_get_meta( 'newsletter_settings_privacy_policy_link' )
*/


/**
Add Email Builder
**/
function wpdevnews_base_editor_callback( $post ){
	if( 'page' !== $post->post_type ){
		return;
	}
?>
	<div id="wpdevnews-email-builder">

		<div class="wpdevnews-rows">
			<?php wpdevnews_render_rows( $post ); // display saved rows ?>
		</div><!-- .wpdevnews-rows -->

		<div class="wpdevnews-actions">
			<a href="#" class="wpdevnews-add-row button-primary button-large" data-template="col-1">Add 1 Column</a>
			<a href="#" class="wpdevnews-add-row button-primary button-large" data-template="col-2">Add 2 Columns</a>
		</div><!-- .wpdevnews-actions -->

		<div class="wpdevnews-templates" style="display:none;">

			<?php /* == This is the 1 column row template == */ ?>
			<div class="wpdevnews-row wpdevnews-col-1">

				<div class="wpdevnews-row-title">
					<span class="wpdevnews-handle dashicons dashicons-sort"></span>
					<span class="wpdevnews-order">0</span>
					<span class="wpdevnews-row-title-text">1 Column</span>
					<span class="wpdevnews-remove dashicons dashicons-trash"></span>
				</div><!-- .wpdevnews-row-title -->

				<div class="wpdevnews-row-fields">
					<textarea class="wpdevnews-row-input" name="" data-field="content" placeholder="Add HTML here..."></textarea>
					<input class="wpdevnews-row-input" type="hidden" name="" data-field="type" value="col-1">
				</div><!-- .wpdevnews-row-fields -->

			</div><!-- .wpdevnews-row.wpdevnews-col-1 -->

			<?php /* == This is the 2 columns row template == */ ?>
			<div class="wpdevnews-row wpdevnews-col-2">

				<div class="wpdevnews-row-title">
					<span class="wpdevnews-handle dashicons dashicons-sort"></span>
					<span class="wpdevnews-order">0</span>
					<span class="wpdevnews-row-title-text">2 Columns</span>
					<span class="wpdevnews-remove dashicons dashicons-trash"></span>
				</div><!-- .wpdevnews-row-title -->

				<div class="wpdevnews-row-fields">
					<div class="wpdevnews-col-2-left">
						<textarea class="wpdevnews-row-input" name="" data-field="content-1" placeholder="1st column content here..."></textarea>
					</div><!-- .wpdevnews-col-2-left -->
					<div class="wpdevnews-col-2-right">
						<textarea class="wpdevnews-row-input" name="" data-field="content-2" placeholder="2nd column content here..."></textarea>
					</div><!-- .wpdevnews-col-2-right -->
					<input class="wpdevnews-row-input" type="hidden" name="" data-field="type" value="col-2">
				</div><!-- .wpdevnews-row-fields -->

			</div><!-- .wpdevnews-row.wpdevnews-col-2 -->

		</div><!-- .wpdevnews-templates -->

		<?php wp_nonce_field( "wpdevnews_nonce_action", "wpdevnews_nonce" ) ?>

	</div><!-- .wpdevnews-email-builder -->
<?php
}
add_action( 'edit_form_after_editor', 'wpdevnews_base_editor_callback', 10, 2 );

/**
Save Data
**/
function wpdevnews_base_save_post( $post_id, $post ){

	/* Stripslashes Submitted Data */
	$request = stripslashes_deep( $_POST );

	/* Verify/validate */
	if ( ! isset( $request['wpdevnews_nonce'] ) || ! wp_verify_nonce( $request['wpdevnews_nonce'], 'wpdevnews_nonce_action' ) ){
		return $post_id;
	}
	/* Do not save on autosave */
	if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	/* Check post type and user caps. */
	$post_type = get_post_type_object( $post->post_type );
	if ( 'page' != $post->post_type || !current_user_can( $post_type->cap->edit_post, $post_id ) ){
		return $post_id;
	}

	/* == Save, Delete, or Update Email Builder Data == */

	/* Get (old) saved email builder data */
	$saved_data = get_post_meta( $post_id, 'wpdevnews', true );

	/* Get new submitted data and sanitize it. */
	$submitted_data = isset( $request['wpdevnews'] ) ? wpdevnews_sanitize( $request['wpdevnews'] ) : null;

	/* New data submitted, No previous data, create it  */
	if ( $submitted_data && '' == $saved_data ){
		add_post_meta( $post_id, 'wpdevnews', $submitted_data, true );
	}
	/* New data submitted, but it's different data than previously stored data, update it */
	elseif( $submitted_data && ( $submitted_data != $saved_data ) ){
		update_post_meta( $post_id, 'wpdevnews', $submitted_data );
	}
	/* New data submitted is empty, but there's old data available, delete it. */
	elseif ( empty( $submitted_data ) && $saved_data ){
		delete_post_meta( $post_id, 'wpdevnews' );
	}

	/* == Get Selected Page Template == */
	$page_template = isset( $request['page_template'] ) ? esc_attr( $request['page_template'] ) : null;

	/* == Email Builder Template Selected, Save to Post Content == */
	if( 'templates/email-builder.php' == $page_template ){

		/* Email builder content without row/column wrapper */
		$pb_content = wpdevnews_format_post_content_data( $submitted_data );

		/* Post Data To Save */
		$this_post = array(
			'ID'           => $post_id,
			'post_content' => sanitize_post_field( 'post_content', $pb_content, $post_id, 'db' ),
		);

		/**
		 * Prevent infinite loop.
		 * @link https://developer.wordpress.org/reference/functions/wp_update_post/
		 */
		remove_action( 'save_post', 'wpdevnews_base_save_post' );
		wp_update_post( $this_post );
		add_action( 'save_post', 'wpdevnews_base_save_post' );
	}

	/* == Always delete email builder data if page template not selected == */
	else{
		delete_post_meta( $post_id, 'wpdevnews' );
	}
}
add_action( 'save_post', 'wpdevnews_base_save_post', 10, 2 );

/**
Format Email Builder
**/
function wpdevnews_format_post_content_data( $row_datas ){

	/* return if no rows data */
	if( !$row_datas ){
		return '';
	}

	/* Output */
	$content = '';

	/* Loop for each rows */
	foreach( $row_datas as $order => $row_data ){
		$order = intval( $order );

		/* === Row with 1 column === */
		if( 'col-1' == $row_data['type'] ){
			$content .= $row_data['content'] . "\r\n\r\n";
		}
		/* === Row with 2 columns === */
		elseif( 'col-2' == $row_data['type'] ){
			$content .= $row_data['content-1'] . "\r\n\r\n";
			$content .= $row_data['content-2'] . "\r\n\r\n";
		}
	}
	return $content;
}


/**
Render Saved Rows
**/
function wpdevnews_render_rows( $post ){

	/* Get saved rows data and sanitize it */
	$row_datas = wpdevnews_sanitize( get_post_meta( $post->ID, 'wpdevnews', true ) );

	/* Default Message */
	$default_message = 'Please add a row to start!';
    
    /* Create buttons */
    $buttons = array(
        'post',
        'image',
    );

	/* return if no rows data */
	if( !$row_datas ){
		echo '<p class="wpdevnews-rows-message">' . $default_message . '</p>';
		return;
	}
	/* Data available, hide default notice */
	else{
		echo '<p class="wpdevnews-rows-message" style="display:none;">' . $default_message . '</p>';
	}

	/* Loop for each rows */
	foreach( $row_datas as $order => $row_data ){
		$order = intval( $order );

		/* === Row with 1 column === */
		if( 'col-1' == $row_data['type'] ){
			?>
			<div class="wpdevnews-row wpdevnews-col-1">

				<div class="wpdevnews-row-title">
					<span class="wpdevnews-handle dashicons dashicons-sort"></span>
					<span class="wpdevnews-order"><?php echo $order; ?></span>
					<span class="wpdevnews-row-title-text">1 Column</span>
					<span class="wpdevnews-remove dashicons dashicons-trash"></span>
				</div><!-- .wpdevnews-row-title -->

				<div class="wpdevnews-row-fields">
					<textarea class="wpdevnews-row-input" name="wpdevnews[<?php echo $order; ?>][content]" data-field="content" placeholder="Add HTML here..."><?php echo esc_textarea( $row_data['content'] ); ?></textarea>
                    <?php foreach($buttons as $button) {
                        echo '<button class="wpdevnews-button-' . $button . '" type="button">' . ucwords($button) . '</button>';
                    } ?>
					<input class="wpdevnews-row-input" type="hidden" name="wpdevnews[<?php echo $order; ?>][type]" data-field="type" value="col-1">
				</div><!-- .wpdevnews-row-fields -->

			</div><!-- .wpdevnews-row.wpdevnews-col-1 -->
			<?php
		}
		/* === Row with 2 columns === */
		elseif( 'col-2' == $row_data['type'] ){
			?>
			<div class="wpdevnews-row wpdevnews-col-2">

				<div class="wpdevnews-row-title">
					<span class="wpdevnews-handle dashicons dashicons-sort"></span>
					<span class="wpdevnews-order"><?php echo $order; ?></span>
					<span class="wpdevnews-row-title-text">2 Columns</span>
					<span class="wpdevnews-remove dashicons dashicons-trash"></span>
				</div><!-- .wpdevnews-row-title -->

				<div class="wpdevnews-row-fields">
					<div class="wpdevnews-col-2-left">
						<textarea class="wpdevnews-row-input" name="wpdevnews[<?php echo $order; ?>][content-1]" data-field="content-1" placeholder="1st column content here..."><?php echo esc_textarea( $row_data['content-1'] ); ?></textarea>
					</div><!-- .wpdevnews-col-2-left -->
					<div class="wpdevnews-col-2-right">
						<textarea class="wpdevnews-row-input" name="wpdevnews[<?php echo $order; ?>][content-2]" data-field="content-2" placeholder="2nd column content here..."><?php echo esc_textarea( $row_data['content-2'] ); ?></textarea>
					</div><!-- .wpdevnews-col-2-right -->
					<input class="wpdevnews-row-input" type="hidden" name="wpdevnews[<?php echo $order; ?>][type]" data-field="type" value="col-2">
				</div><!-- .wpdevnews-row-fields -->

			</div><!-- .wpdevnews-row.wpdevnews-col-2 -->
			<?php
		}
	}
}


/**
Enqueue Admin Scripts
**/
function wpdevnews_base_admin_scripts( $hook_suffix ){
	global $post_type;

	/* In Page Edit Screen */
	if( 'page' == $post_type && in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

		/* Load Editor/Email Builder Toggle Script */
		wp_enqueue_script( 'wpdevnews-base-admin-editor-toggle', WPDEVNEWS_BASE_URI . 'assets/admin-editor-toggle.js', array( 'jquery' ), WPDEVNEWS_BASE_VERSION );

		/* Enqueue CSS & JS For Email Builder */
		wp_enqueue_style( 'wpdevnews-base-admin', WPDEVNEWS_BASE_URI . 'assets/admin-email-builder.css', array(), WPDEVNEWS_BASE_VERSION );
		wp_enqueue_script( 'wpdevnews-base-admin', WPDEVNEWS_BASE_URI . 'assets/admin-email-builder.js', array( 'jquery', 'jquery-ui-sortable' ), WPDEVNEWS_BASE_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'wpdevnews_base_admin_scripts' );