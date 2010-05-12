<?php

class MhsCatScraper
{
  /*
  MTPetsCatScraper.php
  Evan Cummings
  CS 346
  4.17.10
  
  Scrapes cat and other animals website.
  */
  
  private $url;
  private $HTMLString;
  private $bolds;
  private $keys;

  function MhsCatScraper($url)
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
    $findLineOne = preg_match_all('#^([1-9]{1,2})/([0-9]{1,2})/([1-2][09][0-9]{1,2})&nbsp;&nbsp;&nbsp;\[([0-9]+-[A-X][0-9]+[a-x]?)\](&nbsp;&nbsp;&nbsp;<i><b>(.*?)</b>|<br>)#m', 
                                  $this->HTMLString, $lineOne);
    $findLineTwo = preg_match_all('#<br><b>([a-zA-Z!/]+.*?)</b>\,&nbsp;&nbsp;(.*?)\,&nbsp;&nbsp;(Male|Female|Unknown)\s?(.*)?\,&nbsp;&nbsp;([a-zA-z0-9\s\./]*)&#m', 
                                  $this->HTMLString, $lineTwo);
    $findDescription = preg_match_all('#^([A-Z]+:?\s.+)<hr>$#m', 
                                  $this->HTMLString, $descriptions);
    
    // Formats date for mySQL date.
    for ($i = 0; $i < count($lineOne[0]); $i++)
    {
      $entryOne = str_pad($lineOne[1][$i], 2, '0', STR_PAD_LEFT);
      $entryTwo = str_pad($lineOne[2][$i], 2, '0', STR_PAD_LEFT);
      $formattedDates[$i] = "{$lineOne[3][$i]}-{$entryOne}-{$entryTwo}";
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
      if ($lineTwo[3][$i] == 'Female')
        $sexes[$i] = 'F';
      elseif ($lineTwo[3][$i] == 'Male')
        $sexes[$i] = 'M';
      elseif ($lineTwo[3][$i] == 'Unknown')
        $sexes[$i] = '?';
    }
    
    // Formats fixed.
    for ($i = 0; $i < count($lineOne[3]); $i++)
    {
      if ($lineTwo[4][$i] == 'spayed' || $lineTwo[4][$i] == 'neutered')
        $fixed[$i] = 1;
      elseif ($lineTwo[4][$i] == 'Intact' || $lineTwo[4][$i] == '')
        $fixed[$i] = 0;
    }

    // Formats breed.
    for ($i = 0; $i < count($lineTwo[1]); $i++)
    {
      if ($lineTwo[1][$i] == 'DLH')
      {
        $formattedBreeds[$i] = 'Domestic Long Hair';
        $commonNames[$i] = 2;
      }
      
      elseif ($lineTwo[1][$i] == 'DMH')
      {
        $formattedBreeds[$i] = 'Domestic Medium Hair';
        $commonNames[$i] = 2;
      }
      
      elseif ($lineTwo[1][$i] == 'DSH')
      {
        $formattedBreeds[$i] = 'Domestic Short Hair';
        $commonNames[$i] = 2;
      }
      
      else
      {
        $formattedBreeds[$i] = $lineTwo[1][$i];
        $commonNames[$i] = 3;
      }
    }
    
    $this->pets = array(  "name"          => $lineOne[6],
                          "breed"         => $formattedBreeds,
                          "color"         => $lineTwo[2],
                          "entry_date"    => $formattedDates,
                          "impound_num"   => $lineOne[4],
                          "sex"           => $sexes,
                          "fixed"         => $fixed,
                          "age"           => $lineTwo[5],
                          "description"   => $descriptions[1],
                          "common_name_id"=> $commonNames);
    
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
