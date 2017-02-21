#!/usr/bin/env php

<?php

/**
 * This script parses drupal.org, and creates a txt file with a list of drupal related companies.
 */


$pages = [];
// Currently there are 32 pages, check it and adjust loop accordingly.
for ($i = 0; $i < 32; $i++) {
  $url = "https://www.drupal.org/drupal-services/Development";
  if ($i != 0) {
    $url .= "?page=" . $i;
  }
  $pages[] = file_get_contentS($url);
}
$links = [];
foreach ($pages as $number => $page) {
  $i = 0;
  while ($i = strpos($page, 'node-organization', $i)) {  
    $start = strpos($page, '<a href=', $i);
    $end = strpos($page, '</a>', $i) + 4;
    $links[] = substr($page, $start, $end - $start);
    $i++;
  }
}
$text = "";
foreach($links as $j => $link) {
  $start = strpos($link, '/');
  $end = strpos($link, '">', 0);
  $text .= 'https://www.drupal.org' . substr($link, $start, $end - $start) . "\n";
}
file_put_contents("drupal_companies.txt", $text);
