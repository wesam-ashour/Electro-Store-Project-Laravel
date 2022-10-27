<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    private $users;
    
    public function __construct($users)
    {
      
        $this->users = $users;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users;
    }
}
