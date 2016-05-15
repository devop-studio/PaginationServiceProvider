<?php

namespace Pagination\Interfaces;

interface IAdapterInterface
{
    
    public function getCounter($query);
    
    public function getItems($query, $current, $limit);
    
}
