<?php

class QueryPeer extends BaseQueryPeer
{
    public static function retrieveByQUERY($query)
    {
        $c = new Criteria();
        $c->add(QueryPeer::QUERY, $query);
        return QueryPeer::doSelectOne($c);
    }

    public static function getPopularTags($max = 30)
    {
        $connection = Propel::getConnection();

        $query = 'SELECT %s as query, COUNT(*) as count
              FROM %s
              INNER JOIN %s ON %s = %s
              GROUP BY query
              ORDER BY count DESC';

        $query = sprintf($query,
        QueryPeer::QUERY,
        QueryPeer::TABLE_NAME,
        ReportQueryPeer::TABLE_NAME,
        QueryPeer::ID,
        ReportQueryPeer::QUERY_ID
        );

        $statement = $connection->prepareStatement($query);
        $statement->setLimit($max);

        $resultset = $statement->executeQuery();

        $tags = array();

        $max_count = 0;

        while($resultset->next())
        {
            if (!$max_count)
            {
                $max_count = $resultset->getInt('count');
            }

            $queries[] = array(
        'query' => $resultset->getString('query'),
        'rank' => floor(($resultset->getInt('count') / $max_count * 9) + 1),
        'count' => $resultset->getInt('count')
            );
        }

        ksort($queries);

        return $queries;
    }

}
