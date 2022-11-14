<?php

namespace App\Exports;

use App\Models\Transactions;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExport implements FromCollection
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    private $transactions;

    public function __construct($transactions)
    {
      
        $this->transactions = $transactions;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->transactions;
    }
}
