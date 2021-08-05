<?php class_exists('system\base\View') or exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//<?=env('app.host')?>/<?=env('app.name')?>/app/assets/css/styles.css">
    <link rel="stylesheet" href="//<?=env('app.host')?>/<?=env('app.name')?>/app/assets/css/code.css">
    <link rel="stylesheet" href="//<?=env('app.host')?>/<?=env('app.name')?>/app/assets/css/app.css">
    
    <script type="module" src="//<?=env('app.host')?>/<?=env('app.name')?>/app/assets/js/Employee.js"></script>
    <link rel="stylesheet" href="//<?=env('app.host')?>/<?=env('app.name')?>/app/assets/css/mSelect.css">

    <title>Edit <?php echo $employee->first_name ?> <?php echo $employee->surname ?></title>
</head>
<body>
    <div class="admin">
    <header class="admin__header">
        <a href="#" class="logo">
            
        <h1>Edit <?php echo $employee->first_name ?> <?php echo $employee->surname ?></h1>
        </a>
        <div class="toolbar">
        <button class="btn btn--primary">Add New Employee</button>
        <a href="#" class="logout">
            Log In
        </a>
        </div>
    </header>
    <nav class="admin__nav">
        <ul class="menu">
        <li class="menu__item">
            <a class="menu__link" href="//<?=env('app.host')?>/<?=env('app.name')?>"">Dashboard</a>
        </li>
        <li class="menu__item">
            <a class="menu__link" href="//<?=env('app.host')?>/<?=env('app.name')?>/employee/view">Employees</a>
        </li>
        <li class="menu__item">
            <a class="menu__link" href="//<?=env('app.host')?>/<?=env('app.name')?>/logserror.log">Error Logs</a>
        </li>
        <li class="menu__item">
            <a class="menu__link" href="//<?=env('app.host')?>/<?=env('app.name')?>/README.md">README.md</a>
        </li>
        </ul>
    </nav>
    <main class="admin__main">
        <h2></h2>
        <div class="dashboard">
        <div class="dashboard__item">
            <div class="card">
            <strong><?php echo $employee_count ?></strong> Employees
            </div>
        </div>
        <div class="dashboard__item">
            <div class="card">
            <strong>2</strong> Employee Groups
            </div>
        </div>
        <div class="dashboard__item dashboard__item--full">
            <div class="card-block">
                
<form id="employee_form" action="//<?=env('app.host')?>/<?=env('app.name')?>/Employee/update" method="POST">
    <div id="form_errors" style="display: none">
        
    </div>
    <div class="form-field">
        <label for="first_name">First name:*</label>
        <input validate="isRequired" required="required" type="text" id="first_name" name="first_name" value="<?php echo $employee->first_name ?>"/>
        <small></small>
    </div>
    <div class="form-field">
        <label for="surname">Last name:</label>
        <input type="text" id="surname" name="surname" value="<?php echo $employee->surname ?>">
        <small></small>
    </div>
    <div class="form-field">
        <label for="email">Enail:*</label>
        <input validate="isEmailValid" type="email" required="required" id="email" name="email" value="<?php echo $employee->email ?>">
        <small></small>
    </div>
    <div class="form-field">
        <label for="contact_number">Contact Number:</label>
        <input type="text" type="tel" id="contact_number" name="contact_number" value="<?php echo $employee->contact_number ?>">
        <small></small>
    </div>
    <div class="form-field">
        <label for="start_date">Start Date:</label>
        <input type="text" readonly="readonly" id="start_date" name="start_date" value="<?php echo $employee->start_date ?>">
        <small>This field can not be updated</small>
    </div>
    <div class="form-field">
        <label for="active" style="display:block">Active:</label>
        <input validate="isChecked" type="checkbox" id="active" name="active" value="<?php echo $employee->active ?>" <?php if ($employee->active == 1): ?>checked="checked"<?php endif; ?>>
        <small></small>
    </div>
    <div class="form-field">
        <label for="employee_code">Employee Code:*</label>
        <input type="text" required="required" id="employee_code" name="employee_code" value="<?php echo $employee->employee_code ?>">
        <small></small>
    </div>

    <div >
        <label for="employee_groups">Employee Grups:</label>
        <div id="MSelectContainer">
            <select id="employee_groups"  class="form-control" name="employee_groups[]" multiple="multiple">
            <?php foreach($groups as $group): ?>
                <option value="<?php echo $group->id ?>" <?php if (isset($employee->groups[$group->id])): ?> selected="selected"<?php endif ?> ><?php echo $group->group_name ?></option>
            <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-field">
        <input type="hidden" name="id" value="<?php echo $employee->id ?>">
        <input type="submit" value="Submit">
    </div>
</form>  

            </div>
        </div>
        <p>contact me at <a href="mailto:charlcp@gmail.com">charlcp@gmail.com</a>.</p>
    </main>
    <footer class="admin__footer">
            <ul class="ticker">
                <li class="ticker__item">php: <span>18Y</span></li>
                <li class="ticker__item">Java: <span>6Y</span></li>
                <li class="ticker__item">C#: <span>4Y</span></li>
                <li class="ticker__item">JS: <span>18Y</span></li>
                <li class="ticker__item">HTML: <span>18Y</span></li>
                <li class="ticker__item">Android: <span>4Y</span></li>
                <li class="ticker__item">XML: <span>18Y</span></li>

                <li class="ticker__item">XML: <span>18Y</span></li>
                <li class="ticker__item">XUL: <span>2Y</span></li>
                <li class="ticker__item">ClaML: <span>2Y</span></li>
                <li class="ticker__item">DITA: <span>2Y</span></li>
                <li class="ticker__item">DocBook: <span>2Y</span></li>
                <li class="ticker__item">eLML: <span>2Y</span></li>
                <li class="ticker__item">GIS: <span>2Y</span></li>
                <li class="ticker__item">MathML: <span>2Y</span></li>
                <li class="ticker__item">RSS: <span>2Y</span></li>
                <li class="ticker__item">SOAP: <span>2Y</span></li>
                <li class="ticker__item">SVG: <span>2Y</span></li>
                <li class="ticker__item">XHTML: <span>2Y</span></li>
                <li class="ticker__item">XQuery: <span>2Y</span></li>
                <li class="ticker__item">XPath: <span>2Y</span></li>
                <li class="ticker__item">XSL: <span>2Y</span></li>
                <li class="ticker__item">XUL: <span>2Y</span></li>
                <li class="ticker__item">XSLT: <span>18Y</span></li>
        
                <li class="ticker__item">Kotlin: <span>2Y</span></li>
                <li class="ticker__item">CSS: <span>18Y</span></li>
                <li class="ticker__item">MySQL: <span>18Y</span></li>
                <li class="ticker__item">MSSQL: <span>12Y</span></li>
                <li class="ticker__item">PostgreSQL: <span>12Y</span></li>
                <li class="ticker__item">MongoDB: <span>3Y</span></li>
                <li class="ticker__item">Firebase: <span>2Y</span></li>
                <li class="ticker__item">DynamoDB: <span>2Y</span></li>
                <li class="ticker__item">AWS: <span>4Y</span></li>
                <li class="ticker__item">Delpi: <span>5Y</span></li>
                <li class="ticker__item">Pascal: <span>4Y</span></li>
                <li class="ticker__item">Laravel: <span>6Y</span></li>
                <li class="ticker__item">Symfony: <span>5Y</span></li>
                <li class="ticker__item">Yi: <span>2Y</span></li>
                <li class="ticker__item">CakePHP: <span>5Y</span></li>
                <li class="ticker__item">Angular: <span>2Y</span></li>
                <li class="ticker__item">Vue.js: <span>1Y</span></li>
                <li class="ticker__item">Node.js: <span>5Y</span></li>
                <li class="ticker__item">Debian: <span>7Y</span></li>
                <li class="ticker__item">Kali: <span>2Y</span></li>
                <li class="ticker__item">Apache: <span>18Y</span></li>
                <li class="ticker__item">Delpi: <span>5Y</span></li>
                <li class="ticker__item">Delpi: <span>5Y</span></li>
                <li class="ticker__item">Delpi: <span>5Y</span></li>
            </ul>
    </footer>
    </div>
        
        <main>
            
        </main>
        <footer>
        
        </footer>
   
    
</body>
</html>



