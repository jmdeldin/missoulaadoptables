<?php

class MhsDogScraper
{
  /*
  MhsDogScraper.php
  Evan Cummings
  CS 346
  4.17.10

  Scrapes dog website.
  */

  private $url;
  private $HTMLString;
  private $bolds;
  private $keys;

  function MhsDogScraper($url)
  {
    $this->url = $url;

    // DOMDocument methods to get strings between <b> tags.
    $dom = new DOMDocument('1.0','iso-8859-1');
    @$dom->loadHTMLFile($this->url);
    $this->bolds = $dom->getElementsByTagName("b");

    // HTML source for string manipulation.
    $this->HTMLString = $dom->saveHTML();
  }

  // Scrape the website.
  function scrape()
  {
    // Load the values with perl regular expressions.
    $findNameBreed = preg_match_all('#<b>([A-Za-z]+.*?)</b>.*?<b>([A-Za-z]+.*?)</b>#m',
                                  $this->HTMLString, $nameBreed);
    $findColorSexFixedAge = preg_match_all('#;([a-zA-Z/]+\s?.*?)\,&nbsp;&nbsp;(Male|Female)\s?(.*)?\,&nbsp;&nbsp;([a-zA-z0-9\s\./]*)&#m',
                                  $this->HTMLString, $lineOne);
    $findDate = preg_match_all('#^([1-9]{1,2})/([0-9]{1,2})/([1-2][09][0-9]{1,2})#m',
                                  $this->HTMLString, $entryDates);
    $findImpoundNum = preg_match_all('#\[([0-9][0-9]-[A-X][0-9][0-9][0-9][a-x]?)\]#m',
                                  $this->HTMLString, $impoundNums);
    $findDescription = preg_match_all('#^([A-Z]+:?\s.+)<hr>$#m',
                                  $this->HTMLString, $descriptions);

    // Formats date for mySQL date.
    for ($i = 0; $i < count($entryDates[0]); $i++)
    {
      $entryOne = str_pad($entryDates[1][$i], 2, '0', STR_PAD_LEFT);
      $entryTwo = str_pad($entryDates[2][$i], 2, '0', STR_PAD_LEFT);
      $formatedDates[$i] = "{$entryDates[3][$i]}-{$entryOne}-{$entryTwo}";
    }

    // Removes HTML tags from descriptions array.
    for ($i = 0; $i < count($descriptions[1]); $i++)
    {
      $replace = preg_replace('#<[a-z]+/?>#', ' ', $descriptions[1][$i]);
      $descriptions[1][$i] = $replace;
    }

    // Formats sex.
    for ($i = 0; $i < count($lineOne[2]); $i++)
    {
      if ($lineOne[2][$i] == 'Female')
        $sexes[$i] = 'F';
      else
        $sexes[$i] = 'M';
    }

    // Formats fixed.
    for ($i = 0; $i < count($lineOne[3]); $i++)
    {
      if ($lineOne[3][$i] == 'spayed' || $lineOne[3][$i] == 'neutered')
        $fixed[$i] = 1;
      elseif ($lineOne[3][$i] == "Intact" || $lineOne[3][$i] == '')
        $fixed[$i] = 0;
    }

    for ($i = 0; $i < count($nameBreed[1]); $i++)
    {
      $commonNames[$i] = 1;
    }

    $this->pets = array(  "name"          => $nameBreed[1],
                          "breed"         => $nameBreed[2],
                          "color"         => $lineOne[1],
                          "entry_date"    => $formatedDates,
                          "impound_num"   => $impoundNums[1],
                          "sex"           => $sexes,
                          "fixed"         => $fixed,
                          "age"           => $lineOne[4],
                          "description"   => $descriptions[1],
                          "common_name_id"=>$commonNames);

    return $this->pets;

  }

  // Testing Method.
  function test()
  {
    print $url. "<br><br>";

    if (is_array($this->bolds));
    {
      print "bolds length: " . $this->bolds->length;
      var_dump($this->bolds);
    }

    $this->keys = array_keys($this->pets);

    if (is_array($this->pets))
    {
      for ($i = 0; $i < count($this->pets); $i++)
      {
        print "<br/>{$this->keys[$i]} length: " .
          count($this->pets[$this->keys[$i]]);
      }
      var_dump($this->pets);
    }

  }

}// End.
?>

</body>
</html>