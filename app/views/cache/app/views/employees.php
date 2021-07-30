<?php class_exists('system\base\View') or exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//<?=env('app.host')?>/<?=env('app.name')?>/app/assets/css/styles.css">
    <title>Employee List</title>
</head>
<body>
    <div id="wrapper">
        <nav>
    <div class="top">
        <a class="active" href="home">Home</a>
        <a href="employee/view">View Employees</a>
        <a href="home/contact">Contact Us</a>
    </div>
</nav>
        <h1>Employee List</h1>
        <main>
            
    <table>
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Surname
                </th>
                <th>
                    Email
                </th>
                <th>
                    Tel
                </th>
                <th>
                    Start Date
                </th>
                <th>
                    Active
                </th>
                <th>
                    Code
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($employees as $person): ?>
           
            <tr>
                <td><?php echo $person['first_name'] ?></td>
                <td><?php echo $person['surname'] ?></td>
                <td><?php echo $person['email'] ?></td>
                <td><?php echo $person['contact_number'] ?></td>
                <td><?php echo $person['start_date'] ?></td>
                <td><?php echo $person['active'] ?></td>
                <td><?php echo $person['employee_code'] ?></td>
                <td><a href="employee/edit/<?php echo $person['id'] ?>">Edit</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>   

        </main>
    </div>
</body>
</html>



