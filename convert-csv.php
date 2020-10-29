<?php
  header("content-type:application/csv;charset=UTF-8");
  header("Content-Disposition: attachment; filename=Text-to-Translate.csv");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo "\xEF\xBB\xBF";

  # import secondary language data
  include 'lang-vi.php';
  $secondaryLang = $vLang;

  # remove unnecessary line breaks
  $content = file_get_contents('lang-en.php');
  preg_replace( "/\r|\n/", "", $content );
  $strArry = explode(PHP_EOL, $content);

  # generate csv array
  $csvArry = array(
    array('My Reference', 'English', 'Translation')
  );
  for ($i=0; $i < count($strArry) ; $i++) {
    $itemArry = array();
    if(strpos($strArry[$i], '//') !== false) {
      preg_replace( "/\r|\n/", "", $strArry[$i] );

      array_push($csvArry, array(''));
      array_push($itemArry, $strArry[$i]);
      array_push($csvArry, $itemArry);
    } elseif (strpos($strArry[$i], '$vLang') !== false) {

      $keyStartPoint = strpos($strArry[$i],"['") + 2; // because of ['
      $keyEndPoint = strpos($strArry[$i],"']");
      $keyStrLength = $keyEndPoint - $keyStartPoint;
      $keyStr = substr($strArry[$i], $keyStartPoint, $keyStrLength);

      $valueStartPoint = strpos($strArry[$i],"=") + 3; // because of = '
      $valueEndPoint = strlen($strArry[$i]) - 2;
      $valueStrLength = $valueEndPoint - $valueStartPoint;
      $valueStr = substr($strArry[$i], $valueStartPoint, $valueStrLength);

      array_push($itemArry, $keyStr);
      array_push($itemArry,strip_tags(nl2br(str_replace('\\r\\n', "\r\n", $valueStr))));
      array_push($itemArry, $secondaryLang[$keyStr]);

      array_push($csvArry, $itemArry);
    }
  }

  # generate csv from array
  function generateCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
      fputcsv($output, $row);
    }
    fclose($output);
  }

  generateCSV($csvArry);
?>