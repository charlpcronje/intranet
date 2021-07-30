# Employee Management

## Paths and URL's
URL to intranet: `https://172.29.0.29/intranet/`
Path to Intranet: `\\172.29.0.29\www\html\intranet`


## Project Structure
### Single point of entry
  
__To Support `https`__
```php
    Example of setting a .env variable in this file
    setEnv document.root %{DOCUMENT_ROOT}

    Redirect all HTTP traffic to HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} !=on
    RewriteRule ^.*$ https://%{SERVER_NAME}%{REQUEST_URI} [R,L]
```

Added `.htacces` file with rewrite rules enabled

All trafic directed to `index.php`
After 1st `/` will be sent as query paramater `controller` 
After 2nd `/` will be sent as query paramater `action` 
After 3nd `/` and the ones following that will be in the `params` query parameter

## System Extensions
### Database
> Created a database class that uses MySQLi
MySQLi has prepared statement, this will prevent SQL injection

__Connect to DB__
```php
    // Conections are specified in the .env file, the default connection is called `default`
    $db = new DB('connection_name')`
```

__Fetch a row__
```php
    $user = $db->query('SELECT * FROM users WHERE username = ? AND password = ?', 'test', 'test')->fetchArray();
    echo $user['name'];
```
__OR__
```php
    $user = $db->query('SELECT * FROM users WHERE username = ? AND password = ?',['test', 'test'])->fetchArray();
    echo $user['name'];
```

__Fetch multiple rows__
```php
    $users = $db->query('SELECT * FROM users')->fetchAll();
    foreach ($users as $user) {
        echo $user['name'] . '<br>';
    }
```

__Using a callback function__
> if you do not want the results being stored in an array (useful for large amounts of data)
```php
    $db->query('SELECT * FROM users')->fetchAll(function($user) {
        echo $user['name'];
    });
```
If you need to break the loop:  `return 'break'; ` 

__Get the number of rows__
```php
    $users = $db->query('SELECT * FROM users');
    echo $users->numRows();
```

__Get the affected number of rows__
```php
    $insert = $db->query('INSERT INTO users (username,password,email,name) VALUES (?,?,?,?)', 'test', 'test', 'test@gmail.com', 'Test');
    echo $insert->affectedRows();
```

__Get the total number of queries__
```php
    echo $db->query_count;
```

__Get the last insert ID__
```php
    echo $db->lastInsertID();
```

__Close the database__
```php
    $db->close();
```

### Views
> I created a View Templating class that can be used like this

Specify template te render
```php
View::render('layout.html');
```

Create a new HTML file and name it layout.html and add:
```html
<!DOCTYPE html>
<html>
	<head>
		<title>{% yield title %}</title>
        <meta charset="utf-8">
	</head>
	<body>
    {% yield content %}
    </body>
</html>
```

Now create the index.html file and add:
```html
{% extends layout.html %}

{% block title %}Home Page{% endblock %}

{% block content %}
<h1>Home</h1>
<p>Welcome to the home page!</p>
{% endblock %}
```

Or the template can be called like this
```php
Template::view('about.html', [
    'title' => 'Home Page',
    'colors' => ['red','blue','green']
]);
```

And then we can use it as so:
```html
    {% extends layout.html %}

    {% block title %}{{ $title }}{% endblock %}

    {% block content %}
    <h1>Home</h1>
    <p>Welcome to the home page, list of colors:</p>
    <ul>
        {% foreach($colors as $color): %}
        <li>{{ $color }}</li>
        {% endforeach; %}
    </ul>
    {% endblock %}
```

Extend blocks:
```html
    {% block content %}
    @parent
    <p>Extends content block!</p>
    {% endblock %}
```

Include additional template files:
```html
{% include forms.html %}
```

If we want to remove all the compiled files we can either delete all the files in the cache directory or execute the following code:
```php
View::clearCache();
```

### Model
The Model base class `implements` the `IteratorAgregate` that makes it possible to use your `models`
as an `array` and go through the records with `loops` like `foreach`

In each model you must specify the `table` name and the `key` column of the `table`
```php
class Employee extends Model {

    function __construct($id = null) {
        $this->table = 'employees';
        $this->orderBy = 'employment_date';
        parent::__construct($id,true);
    }
}
```
- By specifying the `$id` the record with that `id` will be fetched
- If the `$orderBy` is specified then the records will be ordered that way
- If the `second argument` is set to `true` then all the records in the table will be fetched


## DB Tables, Foreign keys and Indexes
> I created 2 tables
1. `groups` table that contains a list of employee groups
2. `employee_groups` this table carries the relations between the employees and the group(s) they belong to

> Then I added the following indexes and contraints
1. I added some foreign keys that will cascade delete the relations if an employee is deleted.
2. a Group can also not be deleted if any emloyees belong to that group
3. I added in index to the `active` column in the `employees` table, this might be used a lot to `filter`
4. I added a unique index to the `employee_code` column so that there can't be duplicate `codes`
5. I did not add any indexes to the employee_groups table becuase all `keys` / `foreign keys` are `auto indexed`
6. I also indexed the `start_date` because of the `ordering` in the `column`