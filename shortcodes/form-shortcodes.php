<?php
/**
Shortcode
**/
function wpdev_newsletter_shortcode_output() {
    // Get options
    $wpdevnews = get_option( 'wpdev_newsletter_forms_option_name' ); // Array of All Options
    $enableif = $wpdevnews['enable_inboxfirst_0']; // Enable InboxFirst
    $ifformid = $wpdevnews['inboxfirst_formid_1']; // InboxFirst FormID
    $enablemt = $wpdevnews['enable_maximtech_2']; // Enable MaximTech
    $mtformid = $wpdevnews['maximtech_formid_3']; // MaximTech FormID
    $mtsuccurl = $wpdevnews['maximtech_success_url_4']; // MaximTech Success URL
    $mtfailurl = $wpdevnews['maximtech_failure_url_5']; // MaximTech Failure URL
    $enablemc= $wpdevnews['enable_mailchimp_6']; // Enable MailChimp
    $mcformid = $wpdevnews['mailchimp_formid_7']; // MailChimp FormID
    $mcuserid = $wpdevnews['mailchimp_userid_8']; // MailChimp UserID
    $enablecf = $wpdevnews['enable_custom_form']; // Enable Custom Form
    $cusform = $wpdevnews['custom_form']; // Custom Form
    $formhead = $wpdevnews['form_heading_lead']; // Form Heading
    $formpara = $wpdevnews['form_paragraph_lead']; // Form Paragraph
    $formplace = $wpdevnews['form_field_placeholder_9']; // Form Field Placeholder
    $formshape = $wpdevnews['form_field_shape_10']; // Form Field Shape
    $formbg = $wpdevnews['form_background_color_11']; // Form Background Color
    $formbord = $wpdevnews['form_border_color_12']; // Form Border Color
    $buttontxt = $wpdevnews['button_text_13']; // Button Text
    $buttonstyle = $wpdevnews['button_style_14']; // Button Style
    $buttonshape = $wpdevnews['button_shape_15']; // Button Shape
    $buttontxtcolor = $wpdevnews['button_text_color_16']; // Button Text Color
    $buttonhtxtcolor = $wpdevnews['button_hover_text_color_17']; // Button Hover Text Color
    $buttonbgcolor = $wpdevnews['button_background_color_18']; // Button Background Color
    $buttonhbgcolor = $wpdevnews['button_hover_background_color_19']; // Button Hover Background Color
    $customcss = $wpdevnews['custom_css_20']; // Custom CSS
    
    // Wrapper Template
    $wrap = '<div class="wpdev-news-form">';
    if(!empty($formhead)) {
        $wrap .= '<h2>' . $formhead . '</h2>';
    } else {
        $wrap .= '<h2>Get More Stories Like This <span>In Your Inbox!</span></h2>';
    }
    if(!empty($formpara)) {
        $wrap .= '<p class="wpdev-news-para">' . $formpara . '</p>';
    } else {
        $wrap .= '<p class="wpdev-news-para">Sign up for our daily email and get the stories everyone is talking about.</p>';
    }
    $wrapx = '</div>';
    
    
    // Form Templates
    if(!empty($enableif) && !empty($ifformid)) {
        $form = wpdev_inboxfirst_form($ifformid, $formplace, $buttontxt);
    } elseif(!empty($enablemt) && !empty($mtformid) && !empty($mtsuccurl) && !empty($mtfailurl)) {
        $form = wpdev_maximtech_form($mtformid, $mtsuccurl, $mtfailurl, $formplace, $buttontxt);
    } elseif(!empty($enablemc)) {
        $form = wpdev_mailchimp_form($mcformid, $mcuserid, $formplace, $buttontxt);
    } elseif(!empty($enablecf) && !empty($cusform)) {
        $form = $cusform;
    } else {
        return 'Please enable a form source on the settings page and enter the necessary IDs or code.';
    }
    
    // Get Form CSS
    $css = wpdev_form_css();
    
    if(!empty($form)) {
        return $css . $wrap . $form . $wrapx;
    }
}
add_shortcode('wpdevnewsletter', 'wpdev_newsletter_shortcode_output');

/**
Inbox First Template
**/
function wpdev_inboxfirst_form($id, $placeholder, $button) {
    // Check for custom placeholder
    if(!empty($placeholder) && $placeholder != '') {
        $placeholder = $placeholder;
    } else {
        $placeholder = 'Email Address';
    }
    
    // Check for custom button
    if(!empty($button) && $button != '') {
        $button = $button;
    } else {
        $button = 'Subscribe';
    }
    
    if(!empty($id)) {
        $output = '
        <form accept-charset="UTF-8" action="https://if.inboxfirst.com/ga/front/forms/' . $id . '/subscriptions/" class="simple_form embedded-ga-subscription-form" id="new_pending_subscriber" method="post" name="new_pending_subscriber" novalidate="novalidate" target="_parent">
            <div style="margin:0;padding:0;display:inline">
                <input name="utf8" type="hidden" value="✓">
            </div>
            <ul class="form-fields" style="">
                <li class="form-field clear text required pending_subscriber_email"><input class="string required wpdev-news-email-address" id="pending_subscriber_email" name="pending_subscriber[email]" placeholder="' . $placeholder . '" size="50" type="text"></li>
                <li>
                    <div class="form-actions-container call-to-action">
                        <button class="colored button wpdev-news-form-btn" type="submit">' . $button . '</button>
                    </div>
                </li>
            </ul>
        </form>';
    } else {
        $output = 'Please check your settings. You are missing a list ID.';
    }
    
    return $output;
}

/**
Maxim Tech Template
**/
function wpdev_maximtech_form($id, $succurl, $failurl, $placeholder, $button) {
    // Check for custom placeholder
    if(!empty($placeholder) && $placeholder != '') {
        $placeholder = $placeholder;
    } else {
        $placeholder = 'Email Address';
    }
    
    // Check for custom button
    if(!empty($button) && $button != '') {
        $button = $button;
    } else {
        $button = 'Subscribe';
    }
    
    if(!empty($id) && !empty($succurl) && !empty($failurl)) {
        $output = '
        <form action="https://inboxfirst.maximtech.com/v1/" method="post">
            <div style="margin:0;padding:0;display:inline">
                <input name="utf8" type="hidden" value="✓">
            </div>
            <ul class="form-fields" style="">
                <li class="form-field clear text required pending_subscriber_email"><input class="string required wpdev-news-email-address" id="pending_subscriber_email" name="pending_subscriber[email]" placeholder="' . $placeholder . '" size="50" type="text"></li>
                <input name="ApiKey" type="hidden" value="F8GR4NJKY94T"><input name="PassUrl" type="hidden" value="' . $succurl . '"><input name="FailUrl" type="hidden" value="' . $failurl . '"><input type="hidden" name="FormID" value="' . $id . '">
                <li>
                    <div class="form-actions-container call-to-action">
                        <button class="colored button wpdev-news-form-btn" type="submit">' . $button . '</button>
                    </div>
                </li>
            </ul>
        </form>';
    } else {
        $output = 'Please check your settings. You are either missing the form ID, success URL, or failure URL.';
    }
    
    return $output;
}

/**
Mail Chimp Template
**/
function wpdev_mailchimp_form($id, $userid, $placeholder, $button) {
    // Check for custom placeholder
    if(!empty($placeholder) && $placeholder != '') {
        $placeholder = $placeholder;
    } else {
        $placeholder = 'Email Address';
    }
    
    // Check for custom button
    if(!empty($button) && $button != '') {
        $button = $button;
    } else {
        $button = 'Subscribe';
    }
    
    if(!empty($id) && $id != '' && !empty($userid) && $userid != '') {
        $output = '
        <div id="mc_embed_signup">
            <form action="//americasfreedomfighters.us11.list-manage.com/subscribe/post?u=' . $userid . '&amp;id=' . $id . '" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <div id="mc_embed_signup_scroll">
                    <div class="mc-field-group">
                        <input type="email" value="" name="EMAIL" class="required email wpdev-news-email-address" placeholder="' . $placeholder . '" id="mce-EMAIL">
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_' .  $userid . '_' . $id . '" tabindex="-1" value=""></div>
                    <div class="clear">
                        <input type="submit" class="wpdev-news-form-btn" value="' . $button . '" name="subscribe" id="mc-embedded-subscribe" class="button">
                    </div>
                </div>
            </form>
        </div>';
    } else {
        $output = 'Please check your settings. You are either missing the form ID or the user ID.';
    }
}

/**
CSS
**/
function wpdev_form_css() {
    // Get options
    $wpdevnews = get_option( 'wpdev_newsletter_forms_option_name' ); // Array of All Options
    $formshape = $wpdevnews['form_field_shape_10']; // Form Field Shape
    $formbg = $wpdevnews['form_background_color_11']; // Form Background Color
    $formbord = $wpdevnews['form_border_color_12']; // Form Border Color
    $formheadc = $wpdevnews['form_heading_color']; // Heading Color
    $formparac = $wpdevnews['form_paragraph_color']; // Paragraph Color
    $buttonstyle = $wpdevnews['button_style_14']; // Button Style
    $buttonshape = $wpdevnews['button_shape_15']; // Button Shape
    $buttontxtcolor = $wpdevnews['button_text_color_16']; // Button Text Color
    $buttonhtxtcolor = $wpdevnews['button_hover_text_color_17']; // Button Hover Text Color
    $buttonbgcolor = $wpdevnews['button_background_color_18']; // Button Background Color
    $buttonhbgcolor = $wpdevnews['button_hover_background_color_19']; // Button Hover Background Color
    $customcss = $wpdevnews['custom_css_20']; // Custom CSS
    
    // Begin output
    $output = '<style type="text/css">';
    
    // Default styles
    $output .= '.wpdev-news-form{background:#444;color:#fff;padding:6px 15px 15px;text-align:center}.wpdev-news-form h2 span{display:block;font-size:30px;color:#FEDD7A}.wpdev-news-form h2{font-family:Arial,sans-serif;font-weight:900;font-size:16px;text-align:center;line-height:1}.wpdev-news-form p.wpdev-news-para{font-size:16px}.wpdev-news-email-address{width:100%;padding:10px;outline-color:#FEDD7A}.wpdev-news-form-btn{width:100%;background:#fff;border:1px solid #a1a1a1;text-transform:uppercase;font-weight:900;padding:5px;margin-top:-5px;display:block;transition:all .3s ease;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;cursor:pointer}.wpdev-news-form-btn:hover{background:#FEDD7A;border-color:#FEDD7A}';
    
    // Form
    if(!empty($formbg) && !empty($formbord)) {
        $output .= '.wpdev-news-form{background:' . $formbg . ';border: 1px solid ' . $formbord . '}';
    } elseif(!empty($formbg) && empty($formbord)) {
        $output .= '.wpdev-news-form{background:' . $formbg . '}';
    } elseif(empty($formbg) && !empty($formbord)) {
        $output .= '.wpdev-news-form{border: 1px solid ' . $formbord . '}';
    } else {
        $output .= '';
    }
    
    // Form Shape
    if($formshape == 'field-sharp') {
        $output .= '';
    } else {
        $output .= '.wpdev-news-form{border-radius:6px}';
    }
    
    // Text
    if(!empty($formheadc)) {
        $output .= '.wpdev-news-form h2,.wpdev-news-form h2 span{color:' . $formheadc . '}';
    } else {
        $output .= '';
    }
    
    if(!empty($formparac)) {
        $output .= '.wpdev-news-form p.wpdev-news-para{color:' . $formparac . '}';
    } else {
        $output .= '';
    }
    
    // Button
    if(!empty($buttonbgcolor)) {
        $btncolor = $buttonbgcolor;
    } else {
        $btncolor = '#fff';
    }
    if(!empty($buttonhbgcolor)) {
        $btnhcolor = $buttonhbgcolor;
    } else {
        $btnhcolor = '#FEDD7A';
    }
    
    // Button Styles
    if($buttonstyle == 'button-solid' || empty($buttonstyle)) {
        $output .= '.wpdev-news-form-btn{background:' . $btncolor . '}';
    } elseif($buttonstyle == 'button-outline') {
        $output .= '.wpdev-news-form-btn{background:none;border:2px solid ' . $btncolor . '}.wpdev-news-form-btn:hover{background:' . $btnhcolor . '}';
    } elseif($buttonstyle == 'button-fill') {
        $output .= '.wpdev-news-form-btn{background:' . $btncolor . ';border:2px solid ' . $btncolor . '}.wpdev-news-form-btn:hover{background:none;border-color:' . $btnhcolor . '}';
    } else {
        $output .= '.wpdev-news-form-btn{background:' . $btncolor . ';box-shadow:0 2px ' . $btnhcolor . '}.wpdev-news-form-btn:hover{background:' . $btnhcolor . ';box-shadow:none}';
    }
    
    if(!empty($buttonshape) && $buttonshape == 'button-rounded') {
        $output .= '.wpdev-news-form-btn{border-radius:6px}';
    }
    
    if(!empty($buttontxtcolor)) {
        $output .= '.wpdev-news-form-btn{color:' . $buttontxtcolor . '}';
    }
    if(!empty($buttonhtxtcolor)) {
        $output .= '.wpdev-news-form-btn:hover{color:' . $buttonhtxtcolor . '}';
    }
    
    // Fields
    if(!empty($buttonbgcolor)) {
        $output .= '.wpdev-news-form .wpdev-news-email-address{outline:' . $btncolor . '}';
    }
    
    // Custom CSS
    if(!empty($customcss)) {
        $output .= $customcss;
    }
    
    // End output
    $output .= '</style>';
    
    return $output;
}