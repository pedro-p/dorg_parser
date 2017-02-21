#!/usr/bin/env php

<?php
/**
 * This script parses the list of drupal companies, and 
 * creates a txt file listing the urls of their websites.
 */

$urls = file('drupal_companies.txt');
$text = '';
foreach($urls as $n => $url) {
  echo('$i: ' . $n . "\n");
  $url = trim($url);
  $page = file_get_contents($url);
  $i = strpos($page, 'node-organization');
  $start = strpos($page, '<a href=', $i);
  $end = strpos($page, '</a>', $i) + 4;
  $link = substr($page, $start, $end - $start);
  $s = strpos($link, 'http');
  $e = strpos($link, '">');
  $text .= substr($link, $s, $e - $s) . "\n";
}
file_put_contents('company_urls.txt', $text);
