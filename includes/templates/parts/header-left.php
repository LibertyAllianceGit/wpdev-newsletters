<td class="header container" >
    <div class="content">
        <table bgcolor="#999999">
            <tr>
				<td>
                <?php if(!empty(get_post_meta(get_the_ID(), 'newsletter_settings_logo', true))) { ?>
                    <a href="<?php echo get_bloginfo('url'); ?>"><img src="<?php echo get_post_meta(get_the_ID(), 'newsletter_settings_logo', true); ?>" alt="<?php echo get_bloginfo('name'); ?>" style="max-width: 400px" /></a>
                <?php } else { ?>
                    <h1><a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
                <?php } ?>
                </td>
                <td align="right">
                    <h6 class="collapse"><a href="#">View in Browser</a></h6>
                    <h6 class="collapse"><?php echo date('F j, Y'); ?></h6>
                </td>
            </tr>
        </table>
    </div>
</td>