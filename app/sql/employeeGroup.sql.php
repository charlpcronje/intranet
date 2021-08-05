<?php
return (object)[
    'delete' => "
        DELETE FROM 
            employee_groups
        WHERE employee_id = :employee_id",

    'insert' => "
        INSERT INTO
            employee_groups
            (group_id,employee_id)
        VALUES
        (:group_id,:employee_id)"
];