<?php
  include 'lang-en.php';
  $primaryLang = $vLang;

  unset($vLang);

  include 'lang-vi.php';
  $secondaryLang = $vLang;

  # generate array for csv
  $csvArry = array(
    array('My Reference', 'English', 'Translation')
  );
  foreach ($primaryLang as $key => $value) {
    $itemArry = array();
    array_push($itemArry, $key);
    array_push($itemArry, $value);
    array_push($itemArry, $secondaryLang[$key]);

    array_push($csvArry, $itemArry);
  }

  # generate csv from array
  header('Content-Encoding: UTF-8');
  header("content-type:application/csv;charset=UTF-8");
  header("Content-Disposition: attachment; filename=Text-to-Translate.csv");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo "\xEF\xBB\xBF";

  function generateCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
      fputcsv($output, $row);
    }
    fclose($output);
  }

  generateCSV($csvArry);
?>