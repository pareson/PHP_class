# TableBoard_Shop
게시판-Shop 의 TODO 완성하기!

## 기존 파일
```
 .
├── css - board_form.php와 index.php 에서 사용하는 stylesheet
│   └── ...
├── fonts - 폰트
│   └── ...
├── images - 아이콘 이미지
│   └── ...
├── vender - 외부 라이브러리
│   └── ...
├── js - board_form.php와 index.php 에서 사용하는 javascript
│   └── ...
├── function
│   └── insert.php - 게시글 작성 기능 구현
│   └── update.php - 게시글 수정 기능 구현
│   └── delete.php - 게시글 삭제 기능 구현
├── board_form.php - 게시글 작성/수정 시 사용하는 form이 포함된 php 파일
├── index.php - 게시글 조회 기능 구현
```

## 추가 및 수정된 파일
```
├── function
│   └── insert.php - 게시글 작성 기능 구현
│   └── update.php - 게시글 수정 기능 구현
│   └── delete.php - 게시글 삭제 기능 구현
├── board_form.php - 게시글 작성/수정 시 사용하는 form이 포함된 php 파일
├── index.php - 게시글 조회 기능 구현
```

## MySQL 테이블 생성!

create table tableboard_shop(
num int auto_increment,
date char(20),
order_id char(20),
name char(20),
price float,
quantity int
,primary key(num));

Note: 
- table 이름은 tableboard_shop 으로 생성
- 기본키는 num 으로, 그 외의 속성은 board_form.php 의 input 태그 name 에 표시된 속성 이름으로 생성
- 각 속성의 type 은 자유롭게 설정 (단, 입력되는 값의 타입과 일치해야 함)
    - ex) price -> int
    - ex) name -> char or varchar
    
## index.php 수정
      ```
               <?php
                   # TODO: MySQL 데이터베이스 연결 및 레코드 가져오기!
               
               
               $connect = mysql_connect("localhost","khj","1123");
               mysql_select_db("khj_db",$connect);
               
               $sql = "select * from  tableboard_shop";
               $result = mysql_query($sql,$connect);
               
               mysql_close($connect);
               ?>
       ```
->가장 처음에 db에서 모든 게시글을 가져와, $result에 저장하고 바로 연결을 닫아준다. 
```
             <?php
                                     # TODO : 아래 표시되는 내용을, MySQL 테이블에 있는 레코드로 대체하기!
                                     # Note : column6 에 해당하는 Total 은 Price 값과 Quantity 값의 곱으로 표시!
                                 while($row = mysql_fetch_array($result)) {
                                     ?>
                                     <tr onclick="location.href = ('board_form.php?num=<?echo $row[num]; ?>')">
                                         <td class="column1"><?echo $row[date]; ?></td>
                                         <td class="column2"><?echo $row[order_id]; ?></td>
                                         <td class="column3"><?echo $row[name];?></td>
                                         <td class="column4"><?echo sprintf("%0.2f",$row[price]);?></td>
                                         <td class="column5"><?echo $row[quantity];?></td>
                                         <td class="column6"><?echo $row[price]*$row[quantity];?></td>
                                     </tr>
                                     <?
                                 }
                                 ?>
```
-> 원래 고정된 게시글이 표시되는 지점을 db에서 읽어온 값으로 대체. 게시글이 더 없을때까지 반복해서 출력한다.
total은 php상에서 변수를 곱해 출력해줬다. 
예제에서 price값은 소숫점 2째자리까지 표현했기 때문에,  sprintf를 이용하여 마찬가지로 표현했다.                  


## board_form.php 수정
```
    <?php
    #TODO: update form 인 경우, form 에 정보 표시
    if(isset($_GET[num])) {
        #TODO: MySQL 테이블에서, num에 해당하는 레코드 가져오기
    
        $connect = mysql_connect("localhost","khj","1123");
        mysql_select_db("khj_db",$connect);
        $sql = "select * from Table where num = $_GET[num]";
        $result = mysql_query($sql,$connect);
        mysql_close($connect);
    }
    ?>
    
    if(isset($_GET[num])) { //update 의 경우!
    
                                    ?>
      <td class="column1"> <input name="date" type="text" value="<? echo $row[date] ;?>" /> </td>
      <td class="column2"> <input name="order_id" type="number" value="<? echo $row[order_id] ;?>" /> </td>
      <td class="column3"> <input name="name" type="text" value="<? echo $row[name] ;?>"</td>
      <td class="column4"> <input name="price" type="number" placeholder="$" style="text-align: right;" value="<? echo $row[price] ;?>" /> </td>
      <td class="column5"> <input name="quantity" type="number" value="<? echo $row[quantity] ;?>" style="text-align: right;" /> </td>
      <td class="column6"> $<span id="total"> <? echo $row[quantity]*$row[price]  ;?> </span> </td>
```
위와 마찬가지로, $_GET[num]값이 있으면(update 폼인경우) db에서 정보를 받아와야한다.insert의 경우는 필요 없다.
update form에서 가져온 정보를 토대로, 수정 전 값을 불러와 미리 출력시켜준다.




## function
3가지의 funcction은 기본적으로 비슷한 구조로, 각 페이지에서 입력해줄 sql문의 내용만 조금씩 다르다.

### insert.php 수정

```
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
```


### update.php 수정
# TODO: MySQL DB에서, num에 해당하는 레코드를 POST로 받아온 내용으로 수정하기!
```
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
```
위의 insert 문과 다른점은, 이미 있는 글을 수정하기때문에 num의 값을 꼭 받아와야한다는 점이다. get방식으로 넘어온 num값을 이용해 수정한다.

### delete.php 수정
```
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
```
update와 거의 유사하지만, 처음에 정상접근 판별에서 num값의 세팅만을 판단한다.(다른 채울값이 없기때문)
update와 마찬가지로 num에 해당하는 튜플을 제거한다.
