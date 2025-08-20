<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPost implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Post([
            'title'     => $row[0],
            'image'    => $row[1],
            'description'    => $row[2],
            'excerpt'    => $row[3],
            'status'    => $row[4],
        ]);
    }
}
