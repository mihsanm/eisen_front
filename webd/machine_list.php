<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マシン管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="includes/normalize.css">
    <link rel="stylesheet" type="text/css" href="includes/font-awesome-4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="sass/style.css">
    <link rel="stylesheet" type="text/css" href="includes/jquery-ui.css"/>
    <style>
        #popup{
            display: none;
            border: 1px solid black;
        }
        .cell-which-triggers-popup{
            cursor: pointer;
        }
        .cell-which-triggers-popup:hover{
            background-color: yellow;
        }
    </style>
</head>
<?php
$title = "Untitled Document";
require_once __DIR__ .'/parts/head.php';
require_once __DIR__ . '/parts/modal.php';
require_once __DIR__ . '/includes/DbAction.php';
$dba = new DbAction();
$dbh = $dba->Connect();
?>
<body>
<!-- TODO better popup menu style -->
<div id="popup" data-name="name" class="dialog">
    <a href="">Hello world!</a>
    <p></p>
</div>
<div class="wrapper">
    <?php require_once __DIR__ .'/parts/navigation.php'; ?>
    <div class="contentswrapper">
        <main class="contents menu-set">
            <div class="section">
                <h2 class="title">マシンリスト</h2>
                    <div class="list-tools clearfix">
                            <input type="submit" value="適用" class="button button--form">
                        </div>
                        <div class="search-box">
                            <input type="text" placeholder="全てのパッケージを検索">
                            <div class="search-box__button">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="cbox__selectall">
                                <div class="cbox__wrapper">
                                    <input type="checkbox" id="cbox-selectall"><label for="cbox-selectall"></label>
                                </div>
                            </th>
                            <th>マシン名</th>
                            <th>IPアドレス</th>
                            <th>ポート</th>
                            <th>OS</th>
                            <th>ステータス</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $user_id = $me->get_user_id();
                        $stm = $dbh->prepare("select * from machine_information WHERE user_id=:user_id;");
                        $stm-> bindParam(':user_id', $user_id, PDO::PARAM_STR);
                        $stm->execute();
                        $data = $stm->fetchAll();
                        $cnt  = count($data); //in case you need to count all rows
                        //var_dump($data);
                        foreach ($data as $i => $row)
                            # TODO: print_r need to be splitted for better reading.
                            //$table ='<tr class="cell-which-triggers-popup"><td><input type="checkbox" id="cbox-'.$i.'"><label for="cbox-'.$i.'"></label></td>';
                            //$table.='<td class="machine_name">'.$row['machine_name'].'</td>';
                            //$table.='<td class="ipaddress">'.$row['ipaddress'].'</td>';
                            //$table.='<td>'.$row['port'].'</td>';
                            //$table.='<td>'.$row['os'].'</td>';
                            //$table.='<td>'.$row['status_id'].'</td></tr>';
                            //var_dump($table);
                            print_r('<tr class="cell-which-triggers-popup"><td><input type="checkbox" id="cbox-'.$i.'"><label for="cbox-'.$i.'"></label></td><td class="machine_name">'.$row['machine_name'].'</td><td class="ipaddress">'.$row['ipaddress'].'</td><td>'.$row['port'].'</td><td>'.$row['os'].'</td><td>'.$row['status_id'].'</td></tr>');
                        ?>
                        </tbody>
                    </table>
            <div class="setting">
                <form action="includes/machine_registration.php" method="post">
                    <h2 class="title">json RPC設定</h2>
                    <div class="setting-container">
                        <div class="setting-item-left">
                            <span>ホスト名</span>
                        </div>
                        <div class="setting-item-right">
                            <input type="text" name="js_host">
                        </div>
                    </div>
                    <div class="setting-container">
                        <div class="setting-item-left">
                            <span>ポート番号</span>
                        </div>
                        <div class="setting-item-right">
                            <input type="text" name="js_port">
                        </div>
                    </div>
                    <input type="submit" name="submit" value="設定して次に進む" class="button">
                </form>
            </div>
    </div>
</div>
<script type="text/javascript" src="includes/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="includes/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="includes/jquery/jquery-ui.min.js"></script>
<script>
    //TODO we need all the text in the row divided by some character.
    $( document ).ready(function() {
        $(document).on("click", ".cell-which-triggers-popup", function(event){
            var cell_value = $(event.target).closest('tr').text();
            console.log(cell_value);
            if (cell_value) {
                showPopup(cell_value)
            }
        });

        function showPopup(your_variable){
            $("#popup").dialog({
                width: 500,
                height: 300,
                open: function(){
                    $(this).find("p").html("Hello " + your_variable)
                }
            });
        }
    });
</script>
</body>
</html>