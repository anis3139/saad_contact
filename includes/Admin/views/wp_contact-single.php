<div class="wrap">
    <h1><?php _e( 'Contacts', 'wp_contacts' ); ?></h1>

    <?php $item = wp_contacts_get_contact( $id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'wp_contacts' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'wp_contacts' ); ?>" value="<?php echo esc_attr( $item->name ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-email">
                    <th scope="row">
                        <label for="email"><?php _e( 'Email', 'wp_contacts' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" class="regular-text" placeholder="<?php echo esc_attr( '', 'wp_contacts' ); ?>" value="<?php echo esc_attr( $item->email ); ?>" />
                    </td>
                </tr>
                <tr class="row-phone">
                    <th scope="row">
                        <label for="phone"><?php _e( 'Phone Number', 'wp_contacts' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text" placeholder="<?php echo esc_attr( '', 'wp_contacts' ); ?>" value="<?php echo esc_attr( $item->phone ); ?>" />
                    </td>
                </tr>
                <tr class="row-subject">
                    <th scope="row">
                        <label for="subject"><?php _e( 'Subject', 'wp_contacts' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="subject" id="subject" class="regular-text" placeholder="<?php echo esc_attr( '', 'wp_contacts' ); ?>" value="<?php echo esc_attr( $item->subject ); ?>" />
                    </td>
                </tr>
                <tr class="row-message">
                    <th scope="row">
                        <label for="message"><?php _e( 'Message', 'wp_contacts' ); ?></label>
                    </th>
                    <td>
                        <textarea name="message" id="message"placeholder="<?php echo esc_attr( '', 'wp_contacts' ); ?>" rows="5" cols="30"><?php echo esc_textarea( $item->message ); ?></textarea>
                    </td>
                </tr>
                <tr class="row-created-by">
                    <th scope="row">
                        <label for="created_by"><?php _e( 'Created By', 'wp_contacts' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="created_by" id="created_by" class="regular-text" placeholder="<?php echo esc_attr( '', 'wp_contacts' ); ?>" value="<?php echo esc_attr( $item->created_by ); ?>" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( 'wp_contacts' ); ?>
        <?php submit_button( __( 'Update Contact', 'wp_contacts' ), 'primary', 'wp_contact' ); ?>

    </form>
</div>