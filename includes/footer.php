<html>
<head>
    <title>footer</title>
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
        }

        footer{
            width: 100%; 
            background-color:black ; 
            color:white; 
            text-align:center; 
            font-size:20px;
            padding: 30px 0;
        }

    </style>
</head>

<body>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> XM694. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
