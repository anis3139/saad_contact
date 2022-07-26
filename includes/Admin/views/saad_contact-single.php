<div class="wrap">
    <h1><?php _e('Contacts', 'saad_contacts'); ?>
    </h1>

    <?php $item = get_saad_contact_by_id($id); ?>


    <table class="form-table">
        <tbody>
            <tr class="row-name">
                <th scope="row">
                    <p><?php _e('Name', 'saad_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->name ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-email">
                <th scope="row">
                    <p><?php _e('Email', 'saad_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->email ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-phone">
                <th scope="row">
                    <p><?php _e('Phone Number', 'saad_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->phone ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-subject">
                <th scope="row">
                    <p><?php _e('Subject', 'saad_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->subject ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-message">
                <th scope="row">
                    <p><?php _e('Message', 'saad_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p> <?php echo  $item->message ; ?>
                    </p>
                </td>
            </tr>
            <tr class="row-created-by">
                <th scope="row">
                    <p><?php _e('Created By', 'saad_contacts'); ?>
                    </p>
                </th>
                <td>
                    <p>
                        <?php
                            $user=get_user_by('id', $item->created_by);
                            if ($user) {
                                $fname=$user->user_firstname?$user->user_firstname:'';
                                $lname=$user->user_lastname?$user->user_lastname:'';
                                echo $fname .' '. $lname;
                            }
                         
    ?>
                    </p>

                </td>
            </tr>
            <tr class="row-created-at">
                <th scope="row">
                    <p><?php _e('Created At', 'saad_contacts'); ?>
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