<div class="wrap">
    <div class="notice">
        <?php
        if (isset($_GET['message'])) {
            echo 'Message send Successfully...';
        }
        ?>
    </div>
    <form action="<?php echo the_permalink()?>" method="post"
        id="wp_contact">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e('Name', 'wp_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'wp_contacts'); ?>"
                            value="" required="required" />
                    </td>
                </tr>
                <tr class="row-email">
                    <th scope="row">
                        <label for="email"><?php _e('Email', 'wp_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'wp_contacts'); ?>"
                            value="" />
                    </td>
                </tr>
                <tr class="row-phone">
                    <th scope="row">
                        <label for="phone"><?php _e('Phone Number', 'wp_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'wp_contacts'); ?>"
                            value="" />
                    </td>
                </tr>
                <tr class="row-subject">
                    <th scope="row">
                        <label for="subject"><?php _e('Subject', 'wp_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="subject" id="subject" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'wp_contacts'); ?>"
                            value="" />
                    </td>
                </tr>
                <tr class="row-message">
                    <th scope="row">
                        <label for="message"><?php _e('Message', 'wp_contacts'); ?></label>
                    </th>
                    <td>
                        <textarea name="message" id="message"
                            placeholder="<?php echo esc_attr('', 'wp_contacts'); ?>"
                            rows="5" cols="30"></textarea>
                    </td>
                </tr>
                <tr>
                    <input type="hidden" name="field_id" value="0">
                    <input type="hidden" name="wp_contact" value="1">
                </tr>
            </tbody>
        </table>
        <?php wp_nonce_field('wp_contacts'); ?>

        <input type="submit" value="Submit">


    </form>
</div>