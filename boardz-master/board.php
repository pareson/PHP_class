<!-- 구글 검색 : galley board css => CSS Only Pinterest-like Responsive Board Layout - Boardz.css | CSS ... -->
<!-- 출처 : https://www.cssscript.com/css-pinterest-like-responsive-board-layout-boardz-css/ -->

<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8"> 

    <title>Boardz Demo</title>
    <meta name="description" content="Create Pinterest-like boards with pure CSS, in less than 1kB.">
    <meta name="author" content="Burak Karakan">
    <meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
    <link rel="stylesheet" href="src/boardz.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/wingcss/0.1.8/wing.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

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
<body>
    <div class="seventyfive-percent  centered-block">
        <!-- Sample code block -->
        <div>    
            <hr class="seperator">

            <!-- Example header and explanation -->
            <div class="text-center">
                <h2>Beautiful <strong>Boardz</strong></h2>
                <div style="display: block; width: 50%; margin-right: auto; margin-left: auto; position: relative;">
                    <form class="example" action="board.php" method="post">
                        <input type="text" placeholder="Search.." name="search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>

            <!--<hr class="seperator fifty-percent">-->

            <!-- Example Boardz element. -->
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
        </div>

        <hr class="seperator">

    </div>
</body>

</html>