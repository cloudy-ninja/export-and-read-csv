<?php
  // update string with the line break;
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

  // read data from csv
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

  // write codes in the php file
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
