<!--
runner.php
Evan Cummings
CS 346
4.17.10
-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Runner</title>
</head>
<body bgcolor="#ffffff">
<h1>Runner</h1>

<?php
  require "scraper.php";
  require "Loader.php";
  
  $scraper = new scraper("http://montanapets.org/mhs/residentdog.html");
  $newPets = $scraper->scrape();
  //$scraper->test();

  $loader = new Loader($newPets);
  $loader->checkActive();
  $loader->load();
  //$loader->loadRecursive();
  //$loader->printCommand();
?>

</body>
</html>