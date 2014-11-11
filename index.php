<?php
/**
 * Original file: index.php.
 * Date: 12.11.14
 * Time: 1:07
 */


require_once 'vendor/autoload.php';

use FormManager\Bootstrap;

?><html>
<head>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="hero-unit">
<h1>Hello</h1>
<?php
    $myForm = Bootstrap::form([
        'name' => Bootstrap::text()->label('Your name')->set('size', 'lg'),
        'email' => Bootstrap::email()->label('Your email')->set([
            'addon-before' => '@',
            'help' => 'Insert here your email'
        ])
    ]);

    echo $myForm;
?>
</div>

<?php

if(0) {

    ORM::configure('sqlite:./example.db');
    ORM::configure('logging', true);
    ORM::configure('error_mode', PDO::ERRMODE_WARNING);
    ORM::configure('return_result_sets', true); // returns result sets
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

    /*
    ORM::configure('mysql:host=localhost;dbname=my_database');
    ORM::configure('username', 'database_user');
    ORM::configure('password', 'top_secret');
    */

    $db = ORM::get_db();
    $db->exec("
    CREATE TABLE IF NOT EXISTS contact (
        id INTEGER PRIMARY KEY,
        name TEXT,
        email TEXT,
        create_dt INTEGER,
        views INTEGER
    );"
    );

    $contact = ORM::for_table('contact')->create();
    $contact->name = "User" . time();
    $contact->email = "i@lolhost.org";
    $contact->create_dt = time();
    $contact->views = 0;
    $contact->save();

    $count = ORM::for_table('contact')->count();
    var_dump($count);

    $items = ORM::for_table('contact')
        ->where_lte('create_dt', time() - 60)
        ->find_many();

    foreach ($items as $item) {
        echo($item->name . ": " . $item->views . "\r\n");
        $item->views = $item->views + 1;
        $item->save();
    }

}

?>

</body>
</html>
