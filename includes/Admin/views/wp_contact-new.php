<div class="wrap">
    <h1><?php _e('Contacts', 'wp_contacts'); ?>
    </h1>

    <form action="" method="post">

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
                <input hidden type="number" name="created_by" id="created_by" class="regular-text"
                    placeholder="<?php echo esc_attr('', 'wp_contacts'); ?>"
                    value="<?php echo esc_attr(get_current_user_id(), 'wp_contacts');?>" />

            </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field('wp_contacts'); ?>
        <?php submit_button(__('Add New', 'wp_contacts'), 'primary', 'wp_contact'); ?>

    </form>
</div>