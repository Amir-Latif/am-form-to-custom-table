<?php

global $wpdb;
$table_name = $wpdb->prefix . 'amftut_custom_table';
$table_columns = $wpdb->get_results("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name';");
?>

<div class="wrap">
    <h1>The Data Obtained From The Customer</h1>
    <?php
    if (empty($table_records)) { ?>
        <h3>No data available in the table</h3>
    <?php
    } else { ?>
        <table>
            <tbody>
                <tr>
                    <?php foreach ($table_columns as $column) { ?>
                        <th>
                            <?php echo $column ?>
                        </th>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    <?php
    } ?>

</div>