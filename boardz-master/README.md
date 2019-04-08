# boardz
게시판 검색 기능 완성하기

## 기존 파일
```
 .
├── css
│   └── style.css
├── src
│   └── boardz.css
├── board.html
```

## 추가 및 수정된 파일
```
 .
├── css
│   └── style.css
├── src
│   └── boardz.css
├── board.php (수정)
```

## board.php (수정)
HEAD 밑의 db 연결부분.
```
<?php

//여기서부터 db와 연결하는 부분.
$connect = mysql_connect("localhost","khj","1123");
mysql_select_db("khj_db",$connect);

if($_POST[search] == null)//검색값이 없으면 모든 결과, 검색값이 있으면 그 검색에 해당하는 결과만 쓴다.
{
    $sql = " select count(*) as cnt from boardz";
    $result = mysql_query($sql,$connect);
    $row = mysql_fetch_assoc($result);

    $count = $row[cnt];//검색에 잡힌 총 게시글 수를 구한다.

    $sql = "select * from boardz";

}
else {
    $sql = " select count(*) as cnt from boardz where title like '%$_POST[search]%' ";
    $result = mysql_query($sql,$connect);
    $row = mysql_fetch_assoc($result);

    $count = $row[cnt];//검색에 잡힌 총 게시글 수를 구한다.

    $sql = "select * from boardz where title like '%$_POST[search]%'";
}
$result = mysql_query($sql,$connect);
//이 시점에서 게시글에 대한 검색 및 저장은 $result에 완료되었다. 중간에 mysql connect가 열린 채로 끝나지 않도록 바로 close 해준다.
//$count에 검색된 게시글 갯수도 저장되어있다.

mysql_close($connect);

//db와 통신이 끝났다.
?>
```
총 갯수를 불러와야 페이지에 표시할 열의 수를 구할 수 있으므로, $count를 구하는 sql문이  들어가있다.

```
 <div class="boardz centered-block beautiful">

                <?
                //todo: 게시글 수가 3개가 넘을경우 ul 3개, 아닐경우 ul n개.

                switch ($count){//$count는 검색된 게시글 수.

                    case 0://결과가 없을 시 ul 갯수는 상관 없다.
                        break;

                    case 1://ul이 1개 ,게시글도 한개.
                        {
                            $row = mysql_fetch_array($result); //결과가 1개뿐이므로 한번만.
                            //여기서부터는 각 게시글을 출력.

                                ?>
                            <ul>
                                <li>
                                <h1><? echo $row[title]; ?></h1>

                                <? echo $row[contents]; ?>


                                    <img src="<? echo $row[image_url]; ?>" alt="demo image"/>
                                </li>
                            </ul>
                                <?
                        }
                        break;//1개일때 끝.

                    case 2://ul이 2개, 게시글도 2개.
                        {
                            for($i = 0; $i < 2; $i++)
                            {
                                $row = mysql_fetch_array($result);
                                ?>


                                <ul>
                                    <li>
                                    <h1><? echo $row[title]; ?></h1>

                                    <? echo $row[contents]; ?>


                                        <img src="<? echo $row[image_url]; ?>" alt="demo image"/>
                                    </li>
                                </ul>

                                <?
                            }

                        }
                        break;//2개일때 끝.

                    default://게시글 갯수가 3개 이상이면, ul은 최대 3개까지일 것이다. 그리고 그 ul 안에 count값을 3으로 나눈만큼 게시글을 넣어줘야한다.
                        {
                            $i = 0;//출력에 쓰일 임시 변수.
                            ?>
                            <ul>
                                <?
                                while($i<$count/3) {//count를 3으로 나눈 수만큼 반복.
                                    $row = mysql_fetch_array($result);
                                    ?>
                                    <li>
                                    <h1><? echo $row[title]; ?></h1>

                                    <? echo $row[contents]; ?>
                                        <img src="<? echo $row[image_url]; ?>" alt="demo image"/>
                                    </li>
                                    <?
                                    $i++;//하나 출력시마다 $i 값 증가.
                                }
                                ?>
                            </ul>

                            <ul>
                                <?
                                while($i<$count/3*2) {//위에서 한것 이후, count를 3으로 나눈 수*2까지.
                                    $row = mysql_fetch_array($result);
                                    ?>
                                    <li>
                                    <h1><? echo $row[title]; ?></h1>

                                    <? echo $row[contents]; ?>
                                        <img src="<? echo $row[image_url]; ?>" alt="demo image"/>
                                    </li>
                                    <?
                                    $i++;
                                }
                                ?>
                            </ul>
                            <ul>
                                <?
                                while($row = mysql_fetch_array($result)) {//이젠 남은 값 전부!

                                    ?>
                                    <li>
                                    <h1><? echo $row[title]; ?></h1>

                                    <? echo $row[contents]; ?>
                                        <img src="<? echo $row[image_url]; ?>" alt="demo image"/>
                                    </li>
                                    <?
                                }
                                ?>

                            </ul>

                            <?
                        }
                        break;//3개 이상일때 끝.
                }
                ?>

            </div>
 ```
게시물을 출력하는 부분을 게시물의 갯수에 따라 1열, 2열, 3열로 나누어서 구현하였다.
