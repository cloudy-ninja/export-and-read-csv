<?php
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

  # generate csv from array
  header("Content-type: text/csv");
  header("Content-Disposition: attachment; filename=Text-to-Translate.csv");
  header("Pragma: no-cache");
  header("Expires: 0");

  function generateCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
      fputcsv($output, $row);
    }
    fclose($output);
  }

  generateCSV($csvArry);
?>