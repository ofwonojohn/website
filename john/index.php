<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post"> -->
        <!-- <label for="">x: </label>
        <input type="text" name="x"><br><br>
        <label for="">y: </label>
        <input type="text" name="y"><br><br>
        <label for="">z: </label>
        <input type="text" name="z"><br><br>
        <input type="submit" value="total"> -->

        <!-- <label for="">radius: </label>
        <input type="text" name="radius"><br>
        <input type="submit" value="calculate">

    </form><br> 
</body>
</html> -->
<?php
    // $x = $_POST['x'];
    // $y = $_POST['y'];
    // $z = $_POST['z'];
    // $total = null;

    // $total = abs($x);
    // $total = round($x);
    // $total = floor($x);
    // $total = pow($x, $y);
    // $total = sqrt($x);
    //$total = max($x, $y, $z);
    // $total = pi();
    // $total = rand(1, 100);
    //echo $total;

    // $radius = $_POST['radius'];
    // $circumference = null;
    // $area = null;
    // $volume = null;

    // $circumference = 2 * pi() * $radius;
    // $circumference = round($circumference, 2);

    // $area = pi() * pow($radius, 2);
    // $area = round($area, 2);

    // $volume = 3/4 * pi() * pow($radius, 2);
    // $volume = round($volume, 2);


    // echo"The Circumference is {$circumference}cm <br>";
    // echo"Area = {$area}cm^2 <br>";
    // echo"Volume = {$volume}cm^3 <br>";

    //if statment = if condition is true, do something else, break

    $hours = -1;
    $rate = 20;
    $weekly_pay = null;

    if($hours <= 0){
        $weekly_pay = 0;
    }
    elseif($hours <= 40){
        $weekly_pay = $hours * $rate;
    }

    echo"You made \${$weekly_pay} this week";
?>