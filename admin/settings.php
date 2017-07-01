<?php
// Settings Page
class WPDevNewsletter {
    // Setup options
    private $wpdev_newsletter_forms_options;

    // Construct admin pages
	public function __construct() {
		add_action('admin_menu', array($this, 'wpdev_newsletter_add_plugin_page'));
		add_action('admin_init', array($this, 'wpdev_newsletter_forms_init'));
        add_action('admin_init', array($this, 'wpdev_newsletter_templates_init'));
	}

    // Add pages
	public function wpdev_newsletter_add_plugin_page() {
		add_menu_page(
			'Newsletters', // page_title
			'Newsletters', // menu_title
			'manage_options', // capability
			'wpdev-newsletter', // menu_slug
			array( $this, 'wpdev_newsletter_create_admin_page' ), // function
			'dashicons-email-alt', // icon_url
			100 // position
		);
        add_submenu_page(
            'wpdev-newsletter',
            'Documentation',
            'Documentation',
            'manage_options',
            'wpdev-newsletter',
            array( $this, 'wpdev_newsletter_create_admin_page' )
        );
        add_submenu_page(
            'wpdev-newsletter',
            'Form Settings',
            'Form Settings',
            'manage_options',
            'wpdev-newsletter-forms',
            array( $this, 'wpdev_newsletter_submenu_forms_page_callback' )
        );
        add_submenu_page(
            'wpdev-newsletter',
            'Template Settings',
            'Templates Settings',
            'manage_options',
            'wpdev-newsletter-templates',
            array( $this, 'wpdev_newsletter_submenu_templates_page_callback' )
        );
	}
    
    /**
    Documentation Settings Page
    **/
	public function wpdev_newsletter_create_admin_page() { ?>
		<div class="wrap wpdev-newsletter-wrap wpdev-newsletter-wrap-documentation">
			<h2><img src="<?php echo WPDEVNEWS_BASE_URI . 'assets/newsletters-logo.png'; ?>" alt="Newsletters by WP Developers"/></h2>
			<p>Coming soon.</p>
		</div>
	<?php }

    /**
    Form Settings Page
    **/
    public function wpdev_newsletter_submenu_forms_page_callback() { 
        $this->wpdev_newsletter_forms_options = get_option( 'wpdev_newsletter_forms_option_name' ); ?> 
        <div class="wrap wpdev-newsletter-wrap wpdev-newsletter-wrap-documentation">
			<h2><img src="<?php echo WPDEVNEWS_BASE_URI . 'assets/newsletters-logo.png'; ?>" alt="Newsletters by WP Developers"/></h2>
			<p>For easy embedding, us the shortcode: <code>[wpdevnewsletter]</code> or with PHP use: <code>echo do_shortcode('[wpdevnewsletter]');</code>. Shortcodes work in widgets by default.</p>
            <?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'wpdev_newsletter_forms_option_group' );
					do_settings_sections( 'wpdev-newsletter-forms-admin' );
					submit_button(); ?>
			</form>
		</div>
    <?php }
    
    // Register form settings
    public function wpdev_newsletter_forms_init() {
        register_setting(
			'wpdev_newsletter_forms_option_group', // option_group
			'wpdev_newsletter_forms_option_name', // option_name
			array( $this, 'wpdev_newsletter_forms_sanitize' ) // sanitize_callback
		);
		add_settings_section(
			'wpdev_newsletter_forms_setting_section', // id
			'Source', // title
			array( $this, 'wpdev_newsletter_forms_section_info' ), // callback
			'wpdev-newsletter-forms-admin' // page
		);
		add_settings_field(
			'enable_inboxfirst_0', // id
			'Enable InboxFirst', // title
			array( $this, 'enable_inboxfirst_0_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'inboxfirst_formid_1', // id
			'InboxFirst FormID', // title
			array( $this, 'inboxfirst_formid_1_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'enable_maximtech_2', // id
			'Enable MaximTech', // title
			array( $this, 'enable_maximtech_2_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'maximtech_formid_3', // id
			'MaximTech FormID', // title
			array( $this, 'maximtech_formid_3_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'maximtech_success_url_4', // id
			'MaximTech Success URL', // title
			array( $this, 'maximtech_success_url_4_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'maximtech_failure_url_5', // id
			'MaximTech Failure URL', // title
			array( $this, 'maximtech_failure_url_5_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'enable_mailchimp_6', // id
			'Enable MailChimp', // title
			array( $this, 'enable_mailchimp_6_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'mailchimp_formid_7', // id
			'MailChimp FormID', // title
			array( $this, 'mailchimp_formid_7_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
		add_settings_field(
			'mailchimp_userid_8', // id
			'MailChimp UserID', // title
			array( $this, 'mailchimp_userid_8_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
        add_settings_field(
			'enable_custom_form', // id
			'Enable Custom Form', // title
			array( $this, 'enable_custom_form_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
        add_settings_field(
			'custom_form', // id
			'Custom Form', // title
			array( $this, 'custom_form_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_setting_section' // section
		);
        add_settings_section(
			'wpdev_newsletter_forms_formsetting_section', // id
			'Form', // title
			array( $this, 'wpdev_newsletter_forms_section_info' ), // callback
			'wpdev-newsletter-forms-admin' // page
		);
        add_settings_field(
			'form_heading_lead', // id
			'Form Heading', // title
			array( $this, 'form_heading_lead_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
        add_settings_field(
			'form_paragraph_lead', // id
			'Form Paragraph', // title
			array( $this, 'form_paragraph_lead_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
		add_settings_field(
			'form_field_placeholder_9', // id
			'Form Field Placeholder', // title
			array( $this, 'form_field_placeholder_9_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
		add_settings_field(
			'form_field_shape_10', // id
			'Form Field Shape', // title
			array( $this, 'form_field_shape_10_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
		add_settings_field(
			'form_background_color_11', // id
			'Form Background Color', // title
			array( $this, 'form_background_color_11_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
		add_settings_field(
			'form_border_color_12', // id
			'Form Border Color', // title
			array( $this, 'form_border_color_12_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
        add_settings_field(
			'form_heading_color', // id
			'Form Heading Color', // title
			array( $this, 'form_heading_color_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
        add_settings_field(
			'form_paragraph_color', // id
			'Form Paragraph Color', // title
			array( $this, 'form_paragraph_color_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_formsetting_section' // section
		);
        add_settings_section(
			'wpdev_newsletter_forms_buttonsetting_section', // id
			'Button', // title
			array( $this, 'wpdev_newsletter_forms_section_info' ), // callback
			'wpdev-newsletter-forms-admin' // page
		);
		add_settings_field(
			'button_text_13', // id
			'Button Text', // title
			array( $this, 'button_text_13_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
		add_settings_field(
			'button_style_14', // id
			'Button Style', // title
			array( $this, 'button_style_14_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
		add_settings_field(
			'button_shape_15', // id
			'Button Shape', // title
			array( $this, 'button_shape_15_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
		add_settings_field(
			'button_text_color_16', // id
			'Button Text Color', // title
			array( $this, 'button_text_color_16_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
		add_settings_field(
			'button_hover_text_color_17', // id
			'Button Hover Text Color', // title
			array( $this, 'button_hover_text_color_17_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
		add_settings_field(
			'button_background_color_18', // id
			'Button Background Color', // title
			array( $this, 'button_background_color_18_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
		add_settings_field(
			'button_hover_background_color_19', // id
			'Button Hover Background Color', // title
			array( $this, 'button_hover_background_color_19_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_buttonsetting_section' // section
		);
        add_settings_section(
			'wpdev_newsletter_forms_csssetting_section', // id
			'CSS', // title
			array( $this, 'wpdev_newsletter_forms_section_info' ), // callback
			'wpdev-newsletter-forms-admin' // page
		);
		add_settings_field(
			'custom_css_20', // id
			'Custom CSS', // title
			array( $this, 'custom_css_20_callback' ), // callback
			'wpdev-newsletter-forms-admin', // page
			'wpdev_newsletter_forms_csssetting_section' // section
		);
    }
    
    // Forms settings santization
    public function wpdev_newsletter_forms_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['enable_inboxfirst_0'] ) ) {
			$sanitary_values['enable_inboxfirst_0'] = $input['enable_inboxfirst_0'];
		}
		if ( isset( $input['inboxfirst_formid_1'] ) ) {
			$sanitary_values['inboxfirst_formid_1'] = sanitize_text_field( $input['inboxfirst_formid_1'] );
		}
		if ( isset( $input['enable_maximtech_2'] ) ) {
			$sanitary_values['enable_maximtech_2'] = $input['enable_maximtech_2'];
		}
		if ( isset( $input['maximtech_formid_3'] ) ) {
			$sanitary_values['maximtech_formid_3'] = sanitize_text_field( $input['maximtech_formid_3'] );
		}
		if ( isset( $input['maximtech_success_url_4'] ) ) {
			$sanitary_values['maximtech_success_url_4'] = sanitize_text_field( $input['maximtech_success_url_4'] );
		}
		if ( isset( $input['maximtech_failure_url_5'] ) ) {
			$sanitary_values['maximtech_failure_url_5'] = sanitize_text_field( $input['maximtech_failure_url_5'] );
		}
		if ( isset( $input['enable_mailchimp_6'] ) ) {
			$sanitary_values['enable_mailchimp_6'] = $input['enable_mailchimp_6'];
		}
		if ( isset( $input['mailchimp_formid_7'] ) ) {
			$sanitary_values['mailchimp_formid_7'] = sanitize_text_field( $input['mailchimp_formid_7'] );
		}
		if ( isset( $input['mailchimp_userid_8'] ) ) {
			$sanitary_values['mailchimp_userid_8'] = sanitize_text_field( $input['mailchimp_userid_8'] );
		}
        if ( isset( $input['enable_custom_form'] ) ) {
			$sanitary_values['enable_custom_form'] = $input['enable_custom_form'];
		}
        if ( isset( $input['custom_form'] ) ) {
			$sanitary_values['custom_form'] = esc_textarea( $input['custom_form'] );
		}
        if ( isset( $input['form_heading_lead'] ) ) {
			$sanitary_values['form_heading_lead'] = sanitize_text_field( $input['form_heading_lead'] );
		}
        if ( isset( $input['form_paragraph_lead'] ) ) {
			$sanitary_values['form_paragraph_lead'] = sanitize_text_field( $input['form_paragraph_lead'] );
		}
		if ( isset( $input['form_field_placeholder_9'] ) ) {
			$sanitary_values['form_field_placeholder_9'] = sanitize_text_field( $input['form_field_placeholder_9'] );
		}
		if ( isset( $input['form_field_shape_10'] ) ) {
			$sanitary_values['form_field_shape_10'] = $input['form_field_shape_10'];
		}
		if ( isset( $input['form_background_color_11'] ) ) {
			$sanitary_values['form_background_color_11'] = sanitize_text_field( $input['form_background_color_11'] );
		}
		if ( isset( $input['form_border_color_12'] ) ) {
			$sanitary_values['form_border_color_12'] = sanitize_text_field( $input['form_border_color_12'] );
		}
        if ( isset( $input['form_heading_color'] ) ) {
			$sanitary_values['form_heading_color'] = sanitize_text_field( $input['form_heading_color'] );
		}
        if ( isset( $input['form_paragraph_color'] ) ) {
			$sanitary_values['form_paragraph_color'] = sanitize_text_field( $input['form_paragraph_color'] );
		}
		if ( isset( $input['button_text_13'] ) ) {
			$sanitary_values['button_text_13'] = sanitize_text_field( $input['button_text_13'] );
		}
		if ( isset( $input['button_style_14'] ) ) {
			$sanitary_values['button_style_14'] = $input['button_style_14'];
		}
		if ( isset( $input['button_shape_15'] ) ) {
			$sanitary_values['button_shape_15'] = $input['button_shape_15'];
		}
		if ( isset( $input['button_text_color_16'] ) ) {
			$sanitary_values['button_text_color_16'] = sanitize_text_field( $input['button_text_color_16'] );
		}
		if ( isset( $input['button_hover_text_color_17'] ) ) {
			$sanitary_values['button_hover_text_color_17'] = sanitize_text_field( $input['button_hover_text_color_17'] );
		}
		if ( isset( $input['button_background_color_18'] ) ) {
			$sanitary_values['button_background_color_18'] = sanitize_text_field( $input['button_background_color_18'] );
		}
		if ( isset( $input['button_hover_background_color_19'] ) ) {
			$sanitary_values['button_hover_background_color_19'] = sanitize_text_field( $input['button_hover_background_color_19'] );
		}
		if ( isset( $input['custom_css_20'] ) ) {
			$sanitary_values['custom_css_20'] = esc_textarea( $input['custom_css_20'] );
		}
		return $sanitary_values;
	}
    
    // Forms setting info
    public function wpdev_newsletter_forms_section_info() {
        // Nothing needed here.
	}
    
    // Forms callback functions
    public function enable_inboxfirst_0_callback() {
		printf(
			'<input type="checkbox" name="wpdev_newsletter_forms_option_name[enable_inboxfirst_0]" id="enable_inboxfirst_0" value="enable_inboxfirst_0" %s>',
			( isset( $this->wpdev_newsletter_forms_options['enable_inboxfirst_0'] ) && $this->wpdev_newsletter_forms_options['enable_inboxfirst_0'] === 'enable_inboxfirst_0' ) ? 'checked' : ''
		);
	}
	public function inboxfirst_formid_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[inboxfirst_formid_1]" id="inboxfirst_formid_1" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['inboxfirst_formid_1'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['inboxfirst_formid_1']) : ''
		);
	}
	public function enable_maximtech_2_callback() {
		printf(
			'<input type="checkbox" name="wpdev_newsletter_forms_option_name[enable_maximtech_2]" id="enable_maximtech_2" value="enable_maximtech_2" %s>',
			( isset( $this->wpdev_newsletter_forms_options['enable_maximtech_2'] ) && $this->wpdev_newsletter_forms_options['enable_maximtech_2'] === 'enable_maximtech_2' ) ? 'checked' : ''
		);
	}
	public function maximtech_formid_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[maximtech_formid_3]" id="maximtech_formid_3" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['maximtech_formid_3'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['maximtech_formid_3']) : ''
		);
	}
	public function maximtech_success_url_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[maximtech_success_url_4]" id="maximtech_success_url_4" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['maximtech_success_url_4'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['maximtech_success_url_4']) : ''
		);
	}
    
    public function maximtech_failure_url_5_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[maximtech_failure_url_5]" id="maximtech_failure_url_5" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['maximtech_failure_url_5'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['maximtech_failure_url_5']) : ''
		);
	}
	public function enable_mailchimp_6_callback() {
		printf(
			'<input type="checkbox" name="wpdev_newsletter_forms_option_name[enable_mailchimp_6]" id="enable_mailchimp_6" value="enable_mailchimp_6" %s>',
			( isset( $this->wpdev_newsletter_forms_options['enable_mailchimp_6'] ) && $this->wpdev_newsletter_forms_options['enable_mailchimp_6'] === 'enable_mailchimp_6' ) ? 'checked' : ''
		);
	}
	public function mailchimp_formid_7_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[mailchimp_formid_7]" id="mailchimp_formid_7" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['mailchimp_formid_7'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['mailchimp_formid_7']) : ''
		);
	}
	public function mailchimp_userid_8_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[mailchimp_userid_8]" id="mailchimp_userid_8" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['mailchimp_userid_8'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['mailchimp_userid_8']) : ''
		);
	}
    public function enable_custom_form_callback() {
		printf(
			'<input type="checkbox" name="wpdev_newsletter_forms_option_name[enable_custom_form]" id="enable_custom_form" value="enable_custom_form" %s>',
			( isset( $this->wpdev_newsletter_forms_options['enable_custom_form'] ) && $this->wpdev_newsletter_forms_options['enable_custom_form'] === 'enable_custom_form' ) ? 'checked' : ''
		);
	}
    public function custom_form_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="wpdev_newsletter_forms_option_name[custom_form]" id="custom_css_20">%s</textarea>',
			isset( $this->wpdev_newsletter_forms_options['custom_form'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['custom_form']) : ''
		);
	}
    public function form_heading_lead_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_heading_lead]" id="form_heading_lead" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_heading_lead'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_heading_lead']) : ''
		);
	}
    public function form_paragraph_lead_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_paragraph_lead]" id="form_paragraph_lead" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_paragraph_lead'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_paragraph_lead']) : ''
		);
	}
	public function form_field_placeholder_9_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_field_placeholder_9]" id="form_field_placeholder_9" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_field_placeholder_9'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_field_placeholder_9']) : ''
		);
	}
	public function form_field_shape_10_callback() {
		?> <fieldset><?php $checked = ( isset( $this->wpdev_newsletter_forms_options['form_field_shape_10'] ) && $this->wpdev_newsletter_forms_options['form_field_shape_10'] === 'field-sharp' ) ? 'checked' : '' ; ?>
		<label for="form_field_shape_10-0"><input type="radio" name="wpdev_newsletter_forms_option_name[form_field_shape_10]" id="form_field_shape_10-0" value="field-sharp" <?php echo $checked; ?>> Sharp</label><br>
		<?php $checked = ( isset( $this->wpdev_newsletter_forms_options['form_field_shape_10'] ) && $this->wpdev_newsletter_forms_options['form_field_shape_10'] === 'field-rounded' ) ? 'checked' : '' ; ?>
		<label for="form_field_shape_10-1"><input type="radio" name="wpdev_newsletter_forms_option_name[form_field_shape_10]" id="form_field_shape_10-1" value="field-rounded" <?php echo $checked; ?>> Rounded</label></fieldset> <?php
	}
	public function form_background_color_11_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_background_color_11]" id="form_background_color_11" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_background_color_11'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_background_color_11']) : ''
		);
	}
	public function form_border_color_12_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_border_color_12]" id="form_border_color_12" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_border_color_12'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_border_color_12']) : ''
		);
	}
    public function form_heading_color_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_heading_color]" id="form_heading_color" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_heading_color'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_heading_color']) : ''
		);
	}
    public function form_paragraph_color_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[form_paragraph_color]" id="form_paragraph_color" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['form_paragraph_color'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['form_paragraph_color']) : ''
		);
	}
	public function button_text_13_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[button_text_13]" id="button_text_13" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['button_text_13'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['button_text_13']) : ''
		);
	}
	public function button_style_14_callback() {
		?> <fieldset><?php $checked = ( isset( $this->wpdev_newsletter_forms_options['button_style_14'] ) && $this->wpdev_newsletter_forms_options['button_style_14'] === 'button-solid' ) ? 'checked' : '' ; ?>
		<label for="button_style_14-0"><input type="radio" name="wpdev_newsletter_forms_option_name[button_style_14]" id="button_style_14-0" value="button-solid" <?php echo $checked; ?>> Solid</label><br>
		<?php $checked = ( isset( $this->wpdev_newsletter_forms_options['button_style_14'] ) && $this->wpdev_newsletter_forms_options['button_style_14'] === 'button-outline' ) ? 'checked' : '' ; ?>
		<label for="button_style_14-1"><input type="radio" name="wpdev_newsletter_forms_option_name[button_style_14]" id="button_style_14-1" value="button-outline" <?php echo $checked; ?>> Outline to Fill</label><br>
		<?php $checked = ( isset( $this->wpdev_newsletter_forms_options['button_style_14'] ) && $this->wpdev_newsletter_forms_options['button_style_14'] === 'button-fill' ) ? 'checked' : '' ; ?>
		<label for="button_style_14-2"><input type="radio" name="wpdev_newsletter_forms_option_name[button_style_14]" id="button_style_14-2" value="button-fill" <?php echo $checked; ?>> Fill to Outline</label><br>
		<?php $checked = ( isset( $this->wpdev_newsletter_forms_options['button_style_14'] ) && $this->wpdev_newsletter_forms_options['button_style_14'] === 'button-3d' ) ? 'checked' : '' ; ?>
		<label for="button_style_14-3"><input type="radio" name="wpdev_newsletter_forms_option_name[button_style_14]" id="button_style_14-3" value="button-3d" <?php echo $checked; ?>> 3D</label></fieldset> <?php
	}
	public function button_shape_15_callback() {
		?> <fieldset><?php $checked = ( isset( $this->wpdev_newsletter_forms_options['button_shape_15'] ) && $this->wpdev_newsletter_forms_options['button_shape_15'] === 'button-sharp' ) ? 'checked' : '' ; ?>
		<label for="button_shape_15-0"><input type="radio" name="wpdev_newsletter_forms_option_name[button_shape_15]" id="button_shape_15-0" value="button-sharp" <?php echo $checked; ?>> Sharp</label><br>
		<?php $checked = ( isset( $this->wpdev_newsletter_forms_options['button_shape_15'] ) && $this->wpdev_newsletter_forms_options['button_shape_15'] === 'button-rounded' ) ? 'checked' : '' ; ?>
		<label for="button_shape_15-1"><input type="radio" name="wpdev_newsletter_forms_option_name[button_shape_15]" id="button_shape_15-1" value="button-rounded" <?php echo $checked; ?>> Rounded</label></fieldset> <?php
	}
	public function button_text_color_16_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[button_text_color_16]" id="button_text_color_16" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['button_text_color_16'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['button_text_color_16']) : ''
		);
	}
	public function button_hover_text_color_17_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[button_hover_text_color_17]" id="button_hover_text_color_17" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['button_hover_text_color_17'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['button_hover_text_color_17']) : ''
		);
	}
	public function button_background_color_18_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[button_background_color_18]" id="button_background_color_18" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['button_background_color_18'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['button_background_color_18']) : ''
		);
	}
	public function button_hover_background_color_19_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpdev_newsletter_forms_option_name[button_hover_background_color_19]" id="button_hover_background_color_19" value="%s">',
			isset( $this->wpdev_newsletter_forms_options['button_hover_background_color_19'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['button_hover_background_color_19']) : ''
		);
	}
	public function custom_css_20_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="wpdev_newsletter_forms_option_name[custom_css_20]" id="custom_css_20">%s</textarea>',
			isset( $this->wpdev_newsletter_forms_options['custom_css_20'] ) ? esc_attr( $this->wpdev_newsletter_forms_options['custom_css_20']) : ''
		);
	}
    
    /**
    Template Settings Page
    **/
    public function wpdev_newsletter_submenu_templates_page_callback() {
        //$this->wpdev_newsletter_templates_options = get_option('wpdev_newsletter_templates_options_name'); ?>
        <div class="wrap wpdev-newsletter-wrap wpdev-newsletter-wrap-templates">
			<h2><img src="<?php echo WPDEVNEWS_BASE_URI . 'assets/newsletters-logo.png'; ?>" alt="Newsletters by WP Developers"/></h2>
			<p>Coming soon.</p>
            <?php /*settings_errors(); ?>
            <form method="post" action="options.php">
                <?php
                    settings_fields('wpdev_newsletter_templates_option_group');
                    do_settings_sections('wpdev-newsletter-templates-admin');
                    submit_button();
                ?>
            </form>*/ ?>
		</div>
    <?php }
    
    // Register template settings
    public function wpdev_newsletter_templates_init() {
        // Nothing.
    }
}
    
if ( is_admin() )
	$wpdev_newsletter = new WPDevNewsletter();

/**
Load CSS & JS Files for Admin 
**/
function wpdev_newsletter_admin_styles($hook) {    
    wp_enqueue_style('wpdev-newsletter-admin-css', WPDEVNEWS_BASE_URI . 'admin/css/admin-styles.css');
    wp_enqueue_script('wpdev-newsletter-admin-js', WPDEVNEWS_BASE_URI . 'admin/js/admin-js.js', array('jquery'), WPDEVNEWS_BASE_VERSION, true);
}
add_action('admin_enqueue_scripts', 'wpdev_newsletter_admin_styles', 20);