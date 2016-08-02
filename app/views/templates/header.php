<html>
        <head>
                <title>CodeIgniter Tutorial <?= (strlen($title) > 1 ? " | ".$title : "") ?></title>
                <style>
                    td, th {
                        border: 1px solid #ccc;
                    }
                </style>
                <link rel="shortcut icon" type="image/x-icon" href="ci-icon.ico" />
        </head>
        <body>

            <h1><?php echo $title; ?></h1>
            <p><b>Menu:</b>
                <a href="/">Home</a> |
                <a href="/news">News</a>                
            </p>
                

