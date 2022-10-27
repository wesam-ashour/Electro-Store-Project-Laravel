<?php

namespace App\Exports;

use App\Models\Celebrity;
use Maatwebsite\Excel\Concerns\FromCollection;

class CelebrityExport implements FromCollection
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    private $celebrities;
    
    public function __construct($celebrities)
    {
      
        $this->celebrities = $celebrities;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->celebrities;
    }
}
