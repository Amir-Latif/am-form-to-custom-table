<?php

global $wpdb;
$table_columns = $wpdb->get_results("SELECT COLUMN_NAME, IS_NULLABLE, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wp_amftut';");
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<form id="add-feedback" method="POST">
    <?php
    for ($i = 2; $i < count($table_columns); $i++) {
        // Escapse the posted column from the form
        if ($table_columns[$i]->COLUMN_NAME === "date" || $table_columns[$i]->COLUMN_NAME === "posted") break;

        $field_id = strtolower($table_columns[$i]->COLUMN_NAME);
        $field_name = ucwords(str_replace('_', ' ', $table_columns[$i]->COLUMN_NAME));
        $required = $table_columns[$i]->IS_NULLABLE === "NO" ? "required" : "";

        switch ($table_columns[$i]->DATA_TYPE) {
            case 'tinytext': ?>

                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label h4"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <input id="<?php echo $field_id ?>" class="form-control" name="<?php echo $field_id ?>" type="text" size="255" aria-describedby="<?php echo $field_id ?>" <?php $required ?>>
                </div>
            <?php
                break;

            case 'mediumtext': ?>

                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label h4"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <textarea name="<?php echo $field_id ?>" id="ckeditor-<?php echo $field_id ?>" class="form-control ckeditor"></textarea>
                </div>
            <?php
                break;

            case 'longtext': ?>
                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label h4"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <textarea name="<?php echo $field_id ?>" id="ckeditor-<?php echo $field_id ?>" class="form-control ckeditor"></textarea>
                </div>
            <?php
                break;

            case 'int': ?>
                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label h4"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <input id="<?php echo $field_id ?>" class="form-control" name="<?php echo $field_id ?>" <?php echo $required ?> type="number" value="1" min="1">
                </div>
            <?php
                break;

            case 'tinyint': ?>
                <div class="form-check d-flex align-content-center">
                    <input id="<?php echo $field_id ?>" name="<?php echo $field_id ?>" class="form-check-input" type="checkbox" <?php echo  $required ?>>
                    <label for="<?php echo $field_id ?>" class="form-check-label"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                </div>
    <?php
                break;

            default:
                break;
        }
    }
    ?>
    <button type="submit" class="btn btn-danger">Submit</button>
</form>
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
<script>
    const editors = document.querySelectorAll('.ckeditor');

    for (let i = 0; i < editors.length; i++) {
        ClassicEditor
            .create(document.querySelector(`#ckeditor-${editors[i].name}`))
            .catch(error => {
                console.error(error);
            });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>