<?php

/*

  include 'lang-en.php';
  $primaryLang = $vLang;

  unset($vLang);

  include 'lang-vi.php';
  $secondaryLang = $vLang;

  # generate array for csv
  $csvArry = array();
  foreach ($primaryLang as $key => $value) {
    $itemArry = array();
    $itemArry['My Reference'] = $key;
    $itemArry['English'] = $value;
    $itemArry['Translation'] = $secondaryLang[$key];

    array_push($csvArry, $itemArry);
  }

  function arrayToCSV(array &$array)
  {
    if (count($array) == 0) {
      return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv($df, array_keys(reset($array)));
    foreach ($array as $row) {
      fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
  }

  function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2022 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
  }

  download_send_headers("data_export_" . date("Y-m-d") . ".csv");
  echo arrayToCSV($csvArry);
  die();

*/

  function getStrWithBreak($str) {
    $strArry = explode(PHP_EOL, $str);
    $length = count($strArry);

    $newStr = "";
    for ($i=0; $i < $length ; $i++) {
      if($i == $length - 1) {
        $newStr = $newStr . $strArry[$i];
      } else {
        $newStr = $newStr . $strArry[$i] . "\\r\\n";
      }
    }
    return $newStr;
  }


  $primaryLang = array();
  $secondaryLang = array();

  $row = 1;
  if (($handle = fopen("test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row == 1) {
        $row++;
        continue;
      }
      $num = count($data);
      $row++;
      $primaryLang["vLang['".$data[0]."']"] = '"'.getStrWithBreak($data[1]).'"';
      $secondaryLang["vLang['".$data[0]."']"] = '"'.getStrWithBreak($data[2]).'"';

    }
    fclose($handle);
  }

  function writePhp($dataArry, $fileName) {
    $langFile = fopen($fileName, "w") or die("Unable to open file!");
    $txt = "<?php\n";
    fwrite($langFile, $txt);
    foreach ($dataArry as $key => $value) {
      $txt = "  $$key = $value;\n";
      fwrite($langFile, $txt);
    }
    $txt = "?>";
    fwrite($langFile, $txt);
    fclose($langFile);
  }

  writePhp($primaryLang, 'lang-enn.php');
  writePhp($secondaryLang, 'lang-vin.php');
?>
