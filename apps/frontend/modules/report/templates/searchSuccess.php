<?php if ($pager->getResults()): ?>
    <h1>Search Results</h1>
    <p>The following results matched your query:</p>
    <?php include_partial('report/pager', array('pager' => $pager)) ?>
<?php else: ?>
    <h1>No Results Found</h1>
    <p>We could not find any results with the search term you provided.</p>
<?php endif; ?>