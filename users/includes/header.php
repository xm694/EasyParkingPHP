<?php
session_start();
?>

<html>
<head>
    <title>user header</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        .container{
            width: 80%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1em 0;
        }

        header {
            background-color:black;
            color: white;
            padding: 1em 0;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 1em;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="45" height="45" viewBox="0 0 256 256" xml:space="preserve">
            <defs>
            </defs>
            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                <rect x="16.23" y="16.23" rx="0" ry="0" width="57.54" height="57.54" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(237,242,245); fill-rule: nonzero; opacity: 1;" transform=" matrix(0.7071 -0.7071 0.7071 0.7071 -18.6397 45.0002) "/>
                <path d="M 45 90 L 0 45 L 45 0 l 45 45 L 45 90 z M 8.631 45 L 45 81.37 L 81.37 45 L 45 8.631 L 8.631 45 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(231,82,52); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                <path d="M 49.115 28.915 H 35.926 V 48.08 v 3.051 v 8.937 h 6.103 v -8.937 h 7.087 c 4.978 0 9.028 -4.05 9.028 -9.027 v -4.161 C 58.143 32.965 54.094 28.915 49.115 28.915 z M 52.041 42.104 c 0 1.613 -1.312 2.925 -2.925 2.925 h -7.087 V 35.018 h 7.087 c 1.613 0 2.925 1.312 2.925 2.925 V 42.104 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(9,43,71); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            </g>
        </svg>
            <nav>
                <ul>
                    <li><a href="../users/index.php">Home</a></li>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li><a href="../auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="../index.php">Login</a></li>
                        <li><a href="../index.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>