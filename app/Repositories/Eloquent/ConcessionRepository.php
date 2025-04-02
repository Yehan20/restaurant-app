<?php
namespace App\Repositories\Eloquent;

use App\Models\Concession;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;

class ConcessionRepository extends BaseRepository implements ConcessionRepositoryInterface
{
    public function __construct(Concession $model)
    {
        parent::__construct($model);
    }
    public function getConcussionsPaginated(){
          return $this->model->paginate(10); 
    }
}
