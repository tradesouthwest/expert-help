<?php 
printf(
    '<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
    $args['option_name'],
    $args['name'],
    $args['label_for'],
    $args['value']
);