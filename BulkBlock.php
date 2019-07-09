<?php
  set_time_limit(3600);
  // OAuthライブラリの読み込み
  require "twitteroauth-master/autoload.php";
  use Abraham\TwitterOAuth\TwitterOAuth;
  
  Block_users("48DhYAuqZNADPNoLtfhNnWfkR","06aUAE4rboSSSt5D3Ktc1h8RwcVt2O5wiIa7TdCtmmIAg8c8zf","898819440493514752-qTBelwJ46j32GpSpHvWDbcDo9lV3LI1","simKo7hRJaTLYZTsGsa341PlOxgdxZjLR6JbRdf0Esynv");/*飲む焼売*/

  Block_users("WGWhFfZkuZz0ls1u8g3AZyefb","7HXrvqHdJ0s9qgpEGnl5jvKLsMrB2HI1w48iFDtIfYe3ncz6a7","4863048253-TGYKEV4vK6LzLdRDA08obJCWPinqyDosxdy6aP3","0sAzs1Ovr5LYcRfvljGyl4iuAoacxDV7xChxNlAZAgt4f");/*おとうふ*/


  function Block_users($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret){

    //接続
    $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

    $block_key = preg_split("/、/",file_get_contents("Block_key.txt"));
      //ファイルに入力されたキーワードを配列に格納

    $block_key_ex = "/".implode('|',$block_key)."/";
      //キーワードを正規表現用に加工
    if (file_exists("block_result.txt")){
      unlink("block_result.txt");
    }
    var_dump($block_key);
    var_dump($block_key_ex);
    for($i=0;$i<52;$i++){
      echo $i."回目";
      for($i2=0;$i2<count($block_key);$i2++){
        $search = $connection->get("users/search",["q" => $block_key[$i2],"page"=>$i]);

        for($i3=0;$i3<count($search);$i3++){
          if(preg_match($block_key_ex,$search[$i3]->name)){
            // var_dump($search[$i3]->name);
            file_put_contents("block_result.txt","<c>\t".$search[$i3]->name."\n",FILE_APPEND);
            // $block = $connection->post("blocks/create", ["screen_name" => $search[$i3]->screen_name]);            
          }
        }
      }
    }
  }
?>
