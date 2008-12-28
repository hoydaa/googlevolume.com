<?php if (!isset($pager)): ?>
    <h1>Search</h1>
    <p>Use our search engine to pinpoint exactly what you need on our site.</p>
<?php elseif ($pager->getResults()): ?>
    <h1>Search Results</h1>
    <p>The following results matched your query:</p>
    <?php include_partial('report/pager', array('pager' => $pager)) ?>
<?php else: ?>
    <h1>No Results Found</h1>
    <p>We could not find any results with the search term you provided.</p>
<?php endif; ?>