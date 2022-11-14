<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderItemExport implements FromCollection
{
    private $orders;
    public function __construct($orders)
    {

        $this->orders = $orders;
    }
    use \Maatwebsite\Excel\Concerns\Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->orders;
    }
}