<?php
/**
 * Created by PhpStorm.
 * User: kim2
 * Date: 2019-04-04
 * Time: 오전 9:39
 */

# TODO: MySQL DB에서, num에 해당하는 레코드 삭제하기
if(isset($_GET[num])) {//delete=삭제이므로, num값이 필수적으로 존재해야한다.
    $connect = mysql_connect("localhost", "khj", "1123");
    mysql_select_db("khj_db", $connect);
    $sql = "delete from tableboard_shop where num = $_GET[num] ";
    mysql_query($sql, $connect);

    mysql_close($connect);

    echo "<script> alert('delete complete!') </script>";
}
else{
    echo "<script> alert('wrong access!') </script>";
}

?>

<script>
    location.replace('../index.php');
</script>
