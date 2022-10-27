<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminExport implements FromCollection
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    private $admins;
    
    public function __construct($admins)
    {
      
        $this->admins = $admins;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->admins;
    }
}
