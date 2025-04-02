<?php
 
namespace App\Repositories\Interfaces;

interface ConcessionRepositoryInterface extends BaseRepositoryInterface
{
    // You can add specific methods here if needed
    public function getConcussionsPaginated();
}
