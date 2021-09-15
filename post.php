<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'amftut_custom_table';

    $wpdb->insert($table_name, array(
        'author' => $_POST['amftut_first_input_name'],
        'email' => $_POST['amftut_second_input_name'],
        'anonymously' => $_POST['amftut_seventh_input_name'] ? 1 : 0,
        'career' => $_POST['amftut_third_input_name'],
        'employer' => $_POST['amftut_fourth_input_name'],
        'years_of_experience' => $_POST['amftut_fifth_input_name'],
        'feedback' => $_POST['amftut_sixth_input_name']
    ), array(
        '%s', '%s', '%d', '%s', '%s', '%d', '%s'
    ));
?>