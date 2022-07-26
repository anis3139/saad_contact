<div class="wrap">
    <h1><?php _e('Contacts', 'wp_contacts'); ?>
    </h1>

    <?php $item = wp_contacts_get_contact($id); ?>


    <table class="form-table">
        <tbody>
            <tr class="row-name">
                <th scope="row">
                    <p><?php _e('Name', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->name ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-email">
                <th scope="row">
                    <p><?php _e('Email', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->email ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-phone">
                <th scope="row">
                    <p><?php _e('Phone Number', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->phone ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-subject">
                <th scope="row">
                    <p><?php _e('Subject', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->subject ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-message">
                <th scope="row">
                    <p><?php _e('Message', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->message ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-created-by">
                <th scope="row">
                    <p><?php _e('Created By', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p>
                        <?php
                            $user=get_user_by('id', $item->created_by);
                            echo $user->user_firstname .' '. $user->user_lastname;
                        ?>
                    </p>

                </td>
            </tr>
            <tr class="row-created-at">
                <th scope="row">
                    <p><?php _e('Created At', 'wp_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p>
                        <?php echo date('M d, Y H:i a', strtotime($item->created_at));?>
                    </p>

                </td>
            </tr>
        </tbody>
    </table>
</div>