<div class="wrap">
    <h1><?php _e('Contacts', 'saad_contacts'); ?>
    </h1>

    <?php $item = get_saad_contact_by_id($id); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e('Name', 'saad_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'saad_contacts'); ?>"
                            value="<?php echo esc_attr($item->name); ?>"
                            required="required" />
                    </td>
                </tr>
                <tr class="row-email">
                    <th scope="row">
                        <label for="email"><?php _e('Email', 'saad_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'saad_contacts'); ?>"
                            value="<?php echo esc_attr($item->email); ?>" />
                    </td>
                </tr>
                <tr class="row-phone">
                    <th scope="row">
                        <label for="phone"><?php _e('Phone Number', 'saad_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'saad_contacts'); ?>"
                            value="<?php echo esc_attr($item->phone); ?>" />
                    </td>
                </tr>
                <tr class="row-subject">
                    <th scope="row">
                        <label for="subject"><?php _e('Subject', 'saad_contacts'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="subject" id="subject" class="regular-text"
                            placeholder="<?php echo esc_attr('', 'saad_contacts'); ?>"
                            value="<?php echo esc_attr($item->subject); ?>" />
                    </td>
                </tr>
                <tr class="row-message">
                    <th scope="row">
                        <label for="message"><?php _e('Message', 'saad_contacts'); ?></label>
                    </th>
                    <td>
                        <textarea name="message" id="message"
                            placeholder="<?php echo esc_attr('', 'saad_contacts'); ?>"
                            rows="5"
                            cols="30"><?php echo esc_textarea($item->message); ?></textarea>
                    </td>
                </tr>
                <input type="hidden" name="created_by" id="created_by" class="regular-text"
                    placeholder="<?php echo esc_attr('', 'saad_contacts'); ?>"
                    value="<?php echo esc_attr($item->created_by); ?>" />
            </tbody>
        </table>

        <input type="hidden" name="field_id"
            value="<?php echo $item->id; ?>">

        <?php wp_nonce_field('saad_contacts'); ?>
        <?php submit_button(__('Update Contact', 'saad_contacts'), 'primary', 'saad_contacts'); ?>

    </form>
</div>