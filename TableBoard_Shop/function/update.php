<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, num에 해당하는 레코드를 POST로 받아온 내용으로 수정하기!
if(isset($_GET[num]) && $_POST[order_id] !="") {//update=수정이므로, num값이 필수적으로 존재해야한다.
    $connect = mysql_connect("localhost", "khj", "1123");
    mysql_select_db("khj_db", $connect);
    $sql = "update tableboard_shop set  date = $_POST[date],order_id = $_POST[order_id], name = $_POST[name], price = $_POST[price], quantity = $_POST[quantity] where num = $_GET[num] ";
    mysql_query($sql, $connect);

    mysql_close($connect);

    echo "<script> alert('UPDATE complete!') </script>";
}
else{
    echo "<script> alert('wrong access or empty value!') </script>";
}

?>

<script>
    location.replace('../index.php');
</script>
