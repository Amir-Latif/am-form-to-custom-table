<?php

global $wpdb;
$table_columns = $wpdb->get_results("SELECT COLUMN_NAME, IS_NULLABLE, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wp_amftut_custom_table';");
$fields_count = $wpdb->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wp_amftut_custom_table';");

?>

<form id="add-feedback" method="POST">
    <?php
    for ($i = 1; $i < $fields_count; $i++) {
        $field_id = strtolower($table_columns[$i]->COLUMN_NAME);
        $field_name = ucwords(str_replace('_', ' ', $table_columns[$i]->COLUMN_NAME));
        $required = $table_columns[$i]->IS_NULLABLE === "NO" ? "required" : "";

        switch ($table_columns[$i]->DATA_TYPE) {
            case 'tinytext': ?>

                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <input id="<?php echo $field_id ?>" class="form-control" name="<?php echo $field_id ?>" type="text" aria-describedby="<?php echo $field_id ?>" <?php $required ?>>
                </div>
            <?php
                break;

            case 'longtext': ?>
                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <textarea name="<?php echo $field_id ?>" id="<?php echo $field_id ?>" class="form-control" cols="80" rows="10" <?php echo $required ?>></textarea>
                </div>
            <?php
                break;

            case 'int': ?>
                <div class="form-group">
                    <label for="<?php echo $field_id ?>" class="form-label"><?php echo $field_name ?> <?php if ($required === "required") echo "*" ?></label>
                    <input id="<?php echo $field_id ?>" class="form-control" name="<?php echo $field_id ?>" <?php echo $required ?> type="number" value="0">
                </div>
            <?php
                break;

            case 'tinyint': ?>
                <div class="form-check">
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