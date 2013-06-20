<?php

// Collect all the words to build the suggestion list out of.
$string = strtolower( '<MTEntries lastn="10000"><MTEntryTitle remove_html="1" encode_php="q">
</MTEntries>' );

// Separate phrases (titles) into suggestion words.
$rawkeywords = preg_split('/\s*[\s+\.|\?|,|(|)|\-+|\'|\"|=|;|×|\$|\/|:|{|}]\s*/i', $string);

// Remove duplicates (including uc/lc).
$keywords = array_unique ( $rawkeywords );


// Sort them alphabettically.
sort( $keywords );

//Build the JavaScript array.
echo 'var customarray = new Array( ';

foreach ($keywords as $value) {
  echo "'$value', "; }

echo "'' );";

?>