<?php
  include 'lang-en.php';
  $primaryLang = $vLang;

  unset($vLang);

  include 'lang-vi.php';
  $secondaryLang = $vLang;

  $html = "<table>";
  foreach($primaryLang as $key => $value) {
    $html .= "<tr>";
    $html .= "<td>" . $value . "</td>";
    if (array_key_exists($key, $secondaryLang)) {
      $html .= "<td>" . $secondaryLang[$key] . "</td>";
    } else {
      $html .= "<td style='color: red;'>" . $primaryLang[$key] . "</td>";
    }
    $html .= "</tr>";
  }
  $html .= "</table>";

  echo $html;
?>
