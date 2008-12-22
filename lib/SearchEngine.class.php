<?php

/**
 * Interface for search engines to grab search result size
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
interface SearchEngine
{

    /**
     * Gets result size
     *
     * @param string $query
     * @return string
     */
    public function search($query);

}
