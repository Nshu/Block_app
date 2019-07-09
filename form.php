<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="normalize.css">
  <title>Block_app</title>
</head>

<body>
  <h1>Block_App</h1>
  Block Keyを「、」で区切って入力
  <form action="" method="post">
    <textarea name="block_key"></textarea>
    <br />
    <input type="submit" value="Add from BlockList" name="sub1" />
    <input type="submit" value="Delete from BlockList" name="sub1" />
    <br>
    <input type="submit" value="EXECUTE" name="sub1" />
    <br>
    <input type="submit" value="Show Block key" name="sub1" />
    <br>
  </form>

  <?php
  if (isset($_POST["sub1"])) {//POSTの有無を確認
    $kbn = htmlspecialchars($_POST["sub1"], ENT_QUOTES, "UTF-8");
    $key_src = "Block_key.txt";
    switch ($kbn) {
      case "Add from BlockList":
        if (!empty($_POST["block_key"])){
          file_put_contents($key_src,"、".$_POST["block_key"],FILE_APPEND); 
          //POSTされたblock_keyをBlock_key.txtに追記
          echo "add finished";
        }
        break;
      case "Delete from BlockList":
        if (!empty($_POST["block_key"])){
          // echo $_POST["block_key"];
          // echo str_replace("、".$_POST["block_key"],'',file_get_contents($key_src));
          file_put_contents($key_src,str_replace("、".$_POST["block_key"],'',file_get_contents($key_src)));
          //POSTされたblock_keyをBlock_key.txtから削除
          echo "Delete finished";
        }
        break;
      case "EXECUTE":
        include 'BulkBlock.php';//BulkBlock.phpを実行
        break;
      case "Show Block key":
      //counter.txtの値が1のときに表示。リクエストが来るたびに0と1は反転する。
        $i= file_get_contents("counter.txt");
        $key_buffer = file_get_contents($key_src);
        if (!$i){
          $key_buffer = "//";
        }
        echo "<p>".$key_buffer."</p>";
        file_put_contents("counter.txt", !$i);
        break;
      default:  echo "エラー"; exit;
    }
  }
  ?>
</body>

</html>
