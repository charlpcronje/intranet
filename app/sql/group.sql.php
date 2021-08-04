<?php
return (object)[
    'find' => "
        SELECT
            id, 
            group_name
        FROM
            groups
        WHERE id = :id
        ORDER BY
        group_name ASC",

    'all' => "
        SELECT
            id, 
            group_name
        FROM
            groups
        ORDER BY
        group_name ASC"
];