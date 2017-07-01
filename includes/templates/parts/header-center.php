<td class="header container" >
    <div class="content">
        <!-- Information Bar -->
        <table bgcolor="#999999">
            <tr>
				<td align="left">
                    <h6 class="collapse"><?php echo date('F j, Y'); ?></h6>
                </td>
                <td align="right">
                    <h6 class="collapse"><a href="#">View in Browser</a></h6>
                </td>
            </tr>
        </table>
        <!-- Centered Logo -->
        <table bgcolor="#999999">
            <tr>
				<td align="center">
                <?php if(!empty(get_post_meta(get_the_ID(), 'newsletter_settings_logo', true))) { ?>
                    <a href="<?php echo get_bloginfo('url'); ?>"><img src="<?php echo get_post_meta(get_the_ID(), 'newsletter_settings_logo', true); ?>" alt="<?php echo get_bloginfo('name'); ?>" style="max-width: 400px" /></a>
                <?php } else { ?>
                    <h1><a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
                <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</td>