<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, POST로 받아온 내용 입력하기!

if(isset($_POST[order_id]) && $_POST[order_id] !="") {//입력 주문id 존재여부를 기준으로 삼았다.
    $connect = mysql_connect("localhost", "khj", "1123");
    mysql_select_db("khj_db", $connect);
    $sql = "insert into tableboard_shop set  date = $_POST[date],order_id = $_POST[order_id], name = $_POST[name], price = $_POST[price], quantity = $_POST[quantity] ";
    mysql_query($sql, $connect);

    mysql_close($connect);

    echo "<script> alert('insert complete!') </script>";
}
else{
    echo "<script> alert('wrong access or empty value!') </script>";
}

?>

<script>
    location.replace('../index.php');
</script>
