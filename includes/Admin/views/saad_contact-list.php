<div class="wrap">
    <h2><?php
    _e('Contacts', 'saad_contacts'); ?> <a
            href="<?php echo admin_url('admin.php?page=contacts&action=new'); ?>"
            class="add-new-h2"><?php _e('Add New', 'saad_contacts'); ?></a>
    </h2>

    <form method="GET">
        <input type="hidden" name="page"
            value="<?php echo $_REQUEST['page']; ?>">

        <?php
           $list_table = new Saad_Contacts\Admin\List_Table();
    $list_table->prepare_items();
    $list_table->search_box('search', 'search_id');
    $list_table->display();
    ?>
    </form>


</div>