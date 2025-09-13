<!DOCTYPE html>
<html>
<body>


<form method="post">
    Enter your hight in centimeter(cm): <input type="number" name="hight" required>
    <input type="submit" value="Check">
</form>

<?php
if (isset($_POST['hight'])) {
    $hight = $_POST['hight'];
    if($hight <=149){
        echo "$hight is too short";
    } elseif($hight>=150 && $hight<=164){
        echo "$hight is average";
    } elseif($hight>=165 && $hight<=195){
        echo "$hight is tall";
    }else {
        echo "$hight is too much";
    }
    
}
?>

</body>
</html>