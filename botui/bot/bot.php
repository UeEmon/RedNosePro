<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>チャットボット</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link rel="stylesheet" href="../css/botui-theme-default.css" / -->
    <!-- link rel="stylesheet" href="../css/botui.min.css" / -->
    <link rel="stylesheet" href="https://unpkg.com/botui/build/botui.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/botui/build/botui-theme-default.css" />
  </head>
  <body>
    <div id="botui-app" style="white-space:pre-wrap; word-wrap:break-word;">
      <bot-ui></bot-ui>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.5/vue.min.js"></script>
    <script src="https://unpkg.com/botui/build/botui.min.js"></script>
    
<?php
try {
    // 接続
    $pdo = new PDO('sqlite:./db/botdb.db');

    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定 
    // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // テーブルが存在しない場合はテーブル作成
    $pdo->exec("CREATE TABLE IF NOT EXISTS content(
        value INTEGER PRIMARY KEY AUTOINCREMENT,
        cat_1 VARCHAR(100),
        cat_2 VARCHAR(100),
        question TEXT,
        answer TEXT
    )");

 $sql = "SELECT * FROM content";
  $result = $pdo->query($sql); 
   foreach ($result as $row) {
    //■カラムごとに値を取得
    $val_array[] = $row["value"];
    $cate_array[] =$row["cat_1"];
    $cate2_array[] =$row["cat_2"];
    $que_array[] = $row["question"];
    $ans_array[] = $row["answer"];
  }
    

} catch (Exception $e) {

    echo $e->getMessage() . PHP_EOL;

}
?>

    <script>

      var botui = new BotUI('botui-app');

      var gaPhoto = '../images/sample.png'

      //PHPで取得したカラムごとの値をjavascriptに渡している
      var val_array = <?php echo json_encode($val_array); ?>;
      var cate_array = <?php echo json_encode($cate_array); ?>;
      var cate2_array = <?php echo json_encode($cate2_array); ?>;
      var que_array = <?php echo json_encode($que_array); ?>;
      var ans_array = <?php echo json_encode($ans_array); ?>;

      //第一カテゴリ重複削除し取得
      var category_array = cate_array.filter(function (x, i, self) {
        return self.indexOf(x) === i;
      });

      //初期メッセージ
      botui.message.add({
        photo: gaPhoto,
        content: 'チャットボットです',
        delay: 1000
      }).then(showQuestions);


      //第一カテゴリを表示する関数
      function showQuestions(){

        //第一カテゴリのボタンを作成するためのリスト(q_action)を取得
        var q_action = []
        for(i = 0; i < category_array.length; i++){
          q_action.push({icon: 'circle', text: category_array[i], value: category_array[i]});
        }

        botui.message.add({
          photo: gaPhoto,
          content: '当てはまる項目をお選びください',
          delay: 1000
        }).then(function(){
        //ボタンを表示
        return botui.action.button({
          autoHide: false,
          delay: 1000,
          action: q_action
        });
        }).then(function(res){
          botui.action.hide();
            for (i = 0; i < category_array.length; i++){
              switch(res.value){
                case category_array[i] : category1(i); break;
              }
            }
        });
      }

      //第二カテゴリ及び第二カテゴリがないquestionを表示する関数
      function category1(i){

        //第一カテゴリの値を取得
        var category_value = category_array[i];

        //第二カテゴリ及び第二カテゴリがないquestionを取得
        var category2_array = [];
        for(x = 0; x < cate_array.length; x++){
          if(category_array[i] == cate_array[x] && cate2_array[x] != ""){
            category2_array.push(cate2_array[x]);
          }else if(category_array[i] == cate_array[x] && cate2_array[x] == ""){
            category2_array.push(que_array[x]);
          }
        }

        //第二カテゴリの重複削除し取得
        var category2_array = category2_array.filter(function (x, i, self) {
          return self.indexOf(x) === i;
        });

        //第二カテゴリ及び第二カテゴリがないquestionボタンを作成するためのリスト(q2_action)を取得
        var q2_action = []
        for(i = 0; i < category2_array.length; i++){
          q2_action.push({icon: 'circle', text: category2_array[i], value: category2_array[i]});
        }

        //戻るボタンの追加
        q2_action.push({icon: 'long-arrow-left', text: '1つ戻る', value: 'return'});

        botui.message.add({
          photo: gaPhoto,
          delay: 1000,
          content: '当てはまる項目をお選びください'
        }).then(function(){

          //ボタンを表示
          return botui.action.button({
            autoHide: false,
            delay: 1000,
            action: q2_action
          });
          }).then(function(res){
            botui.action.hide();
              //questionカラムに含まれているか、そうでないかで条件分岐
              if(que_array.includes(res.value)){
                for(i = 0; i < que_array.length; i++){
                  if(res.value == que_array[i] && cate2_array[i] == ""){
                    answer(i);
                    break;
                  }else if(res.value == que_array[i] && cate2_array[i] != ""){
                    var category2_value = cate2_array[i];
                    switch(res.value){
                      case category2_value: category2(category_value, category2_value); break;
                    }
                  }
                }
              }else{
                for (i = 0; i < category2_array.length; i++){
                  var category2_value = category2_array[i];
                  switch(res.value){
                    case category2_value: category2(category_value, category2_value); break;
                  }
                }
              }
              switch(res.value){
                case 'return': showQuestions(); break;
              }
          });
      }


      //第二カテゴリがあるquestionを表示する関数
      function category2(category_value, category2_value){

        //第二カテゴリがあるquestionボタンを作成するためのリスト(q3_action)を取得
        var q3_action = [];
        for(i = 0; i < cate2_array.length; i++){
          if(category_value == cate_array[i] && category2_value == cate2_array[i]){
            q3_action.push({icon: 'circle', text: que_array[i], value: que_array[i]});
          }
        }

        //戻るボタンの追加
        q3_action.push({icon: 'long-arrow-left', text: '1つ戻る', value: 'return'});

        botui.message.add({
          photo: gaPhoto,
          delay: 1000,
          content: '当てはまる項目をお選びください'
        }).then(function(){

        //ボタンを表示
        return botui.action.button({
          autoHide: false,
          delay: 1000,
          action: q3_action
        });
        }).then(function(res){
          botui.action.hide();
            //正しい回答を表示させるための条件分岐
            for(i = 0; i < que_array.length; i++){
              if(category_value == cate_array[i] && category2_value == cate2_array[i]){
                switch(res.value){
                  case que_array[i]: answer(i, category_value, category2_value); break;
                }
              }
            }
            //選んでいたカテゴリに戻るための条件分岐
            for(i = 0; i < category_array.length; i++){
              if(category_array[i] == category_value){
                switch(res.value){
                case 'return': category1(i); break;
                }
              }
            }
        });
      }


      //回答を表示する関数
      function answer(i, category_value, category2_value){
        //回答に含まれているダブルクォーテーションの削除
        var answer = ans_array[i].replace(/"/g, '');
        botui.message.add({
          photo: gaPhoto,
          delay: 1000,
          content: answer
        }).then(function(){
          //category1に戻るための第一カテゴリの要素番号を取得
          for(x = 0; x < category_array.length; x++){
            if(cate_array[i] == category_array[x]){
              var return_cate1 = x;
            }
          }
          //第二カテゴリが空欄かそうでないかで飛ばす関数を変更
          if(cate2_array[i] == ""){
            var nextFunction = 'c1';
          }else{
            var nextFunction = 'c2';
          }
          switch(nextFunction){
            case 'c1': category1(return_cate1); break;
            case 'c2': category2(category_value, category2_value); break;
          }
        });
      }

    </script>


    
      </body>
</html>