<?php 
	$query_text = $query->getQuery();
?>
<a href="http://www.google.com/search?q=<?php echo urlencode($query_text) ?>" target="_blank"><?php echo $query_text ?></a>
