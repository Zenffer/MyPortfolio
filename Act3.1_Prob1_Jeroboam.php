<!DOCTYPE html>
<html>
<body>

<form method="post">
    Enter a number: <input type="number" name="num" required>
    <input type="submit" value="Check">
</form>

<?php
if (isset($_POST['num'])) {
    $num = $_POST['num'];
    if($num % 2 == 0){
        echo "$num is Even";
    } else {
        echo "$num is Odd";
    }
}
?>

</body>
</html>