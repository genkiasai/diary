<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css?v=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>タイトル</title>
    
    <script>
        function selectboxChange() {
            target = document.getElementById("output");

            selindex = document.form1.Select1.selectedIndex;
            switch (selindex) {
                case 1:
                Select1.option[1].selected = false;
                break;
                case 2:
                Select1.selectedindex = 2;
                break;
                case 3:
                Select1.selectedindex = 3;
                break;
                case 4:
                const element = document.querySelector('option');
                element.remove();
                test();
                break;
                case 5:
                Select1.selectedindex = 5;
                break;
            }
        }
    </script>
  </head>
  <body>
  <form name="form1" action="">
      <a href="">aaa</a>
      <input type="hidden">
    <select id="Select1" onchange="selectboxChange();">
        <?php for ($i=2000; $i<=2002; $i++){
            if ($i === 2010) {
                echo "<option value=" . $i . '"' . " " . "selected" . ">" . $i . "</option>";
            }
            echo "<option value=" . $i . '"' . ">" . $i . "</option>";
        } ?>
            




      <option>---</option>
      <option>要素1</option>
      <option>要素2</option>
      <option>要素3</option>
      <option>要素4</option>
      <option>要素5</option>
    </select>
  </form>

  <script>
        function test() {
            document.write("<form name='form1' action=''>");
            document.write("<select id='Select1' onchange='selectboxChange();'>");
            for (let i = 0; i < 5; i++) {
                if (i === 2) {
                    document.write("<option selected>要素" + i + "</option>");
                } else {
                    document.write("<option>要素" + i + "</option>");
                }
            }
            document.write("</select>");
            document.write("</form>");
        }
    </script>
  <div id="output"></div>




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>