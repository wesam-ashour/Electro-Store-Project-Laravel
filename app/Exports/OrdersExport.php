<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    private $orders;

    public function __construct($orders)
    {
      
        $this->orders = $orders;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->orders;
    }
}
