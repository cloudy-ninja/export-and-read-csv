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

?>