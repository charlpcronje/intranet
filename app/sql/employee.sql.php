<?php
return (object)[
    'find' => "
        SELECT
            employee.id, 
            groups.group_name, 
            employee.first_name, 
            employee.surname, 
            employee.email, 
            employee.contact_number, 
            employee.start_date, 
            employee.active, 
            employee.employee_code, 
            employee_groups.group_id
        FROM
            employee
            INNER JOIN
            employee_groups
            ON 
                employee.id = employee_groups.employee_id
            INNER JOIN
            groups
            ON 
                employee_groups.group_id = groups.id
                WHERE employee.id = :id
        ORDER BY
            employee.start_date DESC",

    'all' => "
        SELECT
            employee.id, 
            groups.group_name, 
            employee.first_name, 
            employee.surname, 
            employee.email, 
            employee.contact_number, 
            employee.start_date, 
            employee.active, 
            employee.employee_code, 
            employee_groups.group_id
        FROM
            employee
            INNER JOIN
            employee_groups
            ON 
                employee.id = employee_groups.employee_id
            INNER JOIN
            groups
            ON 
                employee_groups.group_id = groups.id
        ORDER BY
            employee.start_date DESC"
];