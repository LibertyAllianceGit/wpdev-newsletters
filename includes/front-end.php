<?php
/**
Filter Content
**/
function wpdevnews_filter_content( $content ){

	/* In single page when email builder template selected. */
	if( !is_admin() && is_page() && 'templates/email-builder.php' == get_page_template_slug( get_the_ID() ) ){

		/* Add content with shortcode, autoembed, responsive image, etc. */
		$content = wpdevnews_default_content_filter( wpdevnews_get_content() );
	}

	/* Return content */
	return $content;
}
add_filter( 'the_content', 'wpdevnews_filter_content', 10.5 );

/**
Grab the Template
**/
function wpdevnews_email_page_template($page_template) {
    if( !is_admin() && is_page() && 'templates/email-builder.php' == get_page_template_slug( get_the_ID() ) ){
        $page_template = plugin_dir_path(__FILE__) . 'templates/email.php';
    }
    
    return $page_template;
}
add_filter('page_template', 'wpdevnews_email_page_template');

/**
Content Output
**/
function wpdevnews_get_content(){

	/* Get saved rows data and sanitize it */
	$row_datas = wpdevnews_sanitize( get_post_meta( get_the_ID(), 'wpdevnews', true ) );

	/* return if no rows data */
	if( !$row_datas ){
		return '';
	}

	/* Content */
	$content = '';

	/* Loop for each rows */
	foreach( $row_datas as $order => $row_data ){
		$order = intval( $order );

		/* === Row with 1 column === */
		if( 'col-1' == $row_data['type'] ){
			$content .= '<div class="wpdevnews-row wpdevnews-row-' . $order . ' wpdevnews-col-1">' . "\r\n";
			$content .= '<div class="row-content">' . "\r\n\r\n";
			$content .= $row_data['content'] . "\r\n\r\n";
			$content .= '</div>' . "\r\n";
			$content .= '</div>' . "\r\n\r\n";
		}
		/* === Row with 2 columns === */
		elseif( 'col-2' == $row_data['type'] ){
			$content .= '<div class="wpdevnews-row wpdevnews-row-' . $order . ' wpdevnews-col-2">' . "\r\n";
			$content .= '<div class="row-content-1">' . "\r\n\r\n";
			$content .= $row_data['content-1'] . "\r\n\r\n";
			$content .= '</div>' . "\r\n";
			$content .= '<div class="row-content-2">' . "\r\n\r\n";
			$content .= $row_data['content-2'] . "\r\n\r\n";
			$content .= '</div>' . "\r\n";
			$content .= '</div>' . "\r\n\r\n";
		}
	}
	return $content;
}


/**
Enqueue Front End Scripts
**/
add_action( 'wp_enqueue_scripts', 'wpdevnews_base_front_end_scripts' );

/**
Enqueue Admin Scripts
**/
function wpdevnews_base_front_end_scripts(){

	/* In a page using email builder */
	if( is_page() && ( 'templates/email-builder.php' == get_page_template_slug( get_queried_object_id() ) ) ){

		/* Enqueue CSS & JS For Email Builder */
		wp_enqueue_style( 'wpdev-email-builder', WPDEVNEWS_BASE_URI. 'assets/email-builder.css', array(), WPDEVNEWS_BASE_VERSION );
	}
}
