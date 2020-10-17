<!doctype html>
<html lang="en">
<style>
.header ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333333;
    border-bottom: black;
}

.header li {
    float: right;
}

.header li a {
    display: block;
    color: white;
    text-align: center;
    padding: 16px;
    text-decoration: none;
}

.header li a:hover {
    background-color: #111111;
}

.form-group {
    position: relative;
    padding: 50px;
}

.container {
    background-color: white;
    width: 300px;
    height: 300px;
    margin: auto;
    padding: 5px;
}

.kotak {
    padding: 50px;
}

.ucapan {
    padding-left: 300px;
}
</style>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>UD SUMBER HASIL - <?= $data['title'] ?></title>
</head>

<body>
    <div class="header">
        <ul>
            <li><a href="#home"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#news"><i class="fas fa-globe"></i>Page</a></li>
            <li><a href="#contact"><i class="fas fa-phone-square-alt"></i>Contact</a></li>
            <li><a href="#about"><i class="fas fa-info-circle"></i>About</a></li>
        </ul>
    </div>
    <div class="kotak">
        <?php
        Flasher::flash()
        ?>
    </div>