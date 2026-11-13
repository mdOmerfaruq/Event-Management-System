


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['loc'];
    $area = $_POST['area'];
    $unit = (int)$_POST['unit'];

    if ($unit > 0) {
        $bill = $unit * 12.5;
        echo "Location: $location<br>";
        echo "Area: $area<br>";
        echo "Unit Consumed: $unit<br>";
        echo "Total Bill: $bill Taka<br>";
    } else {
        echo "Invalid unit value. Please enter a positive number.";
    }
} else {
    echo "Invalid request method.";
}
?>