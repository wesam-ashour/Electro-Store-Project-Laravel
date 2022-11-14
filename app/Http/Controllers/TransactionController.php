<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $transactions = Transaction::where('status', '1')->paginate(10);

        if ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {
            
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(3))->get();
                $pdf = Pdf::loadView('admin.transactions.myPDF', compact('transactions'));
                return $pdf->download('transactions.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(3))->get();
                return Excel::download(new TransactionsExport($transactions), 'transactions-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(3))->get();
                return (new TransactionsExport($transactions))->download('transactions.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(3))->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(6))->get();
                $pdf = Pdf::loadView('admin.transactions.myPDF', compact('transactions'));
                return $pdf->download('transactions.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(6))->get();
                return Excel::download(new TransactionsExport($transactions), 'transactions-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(6))->get();
                return (new TransactionsExport($transactions))->download('transactions.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(6))->paginate(10);


            } elseif ($request->filter == 3 and $request->export == 1) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(9))->get();
                $pdf = Pdf::loadView('admin.transactions.myPDF', compact('transactions'));
                return $pdf->download('transactions.pdf');
            } elseif ($request->filter == 3 and $request->export == 2) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(9))->get();
                return Excel::download(new TransactionsExport($transactions), 'transactions-collection.xlsx');
            } elseif ($request->filter == 3 and $request->export == 3) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(9))->get();
                return (new TransactionsExport($transactions))->download('transactions.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 3) {
                $transactions = Transaction::where('status', '1')->where("created_at",">", Carbon::now()->subMonths(9))->paginate(10);



            } elseif ($request->filter == 0 and $request->export == 1) {
                $transactions = Transaction::where('status', '1')->paginate(10);
                $pdf = Pdf::loadView('admin.transactions.myPDF', compact('transactions'));
                return $pdf->download('Date_of_registration.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $transactions = Transaction::where('status', '1')->paginate(10);
                return Excel::download(new TransactionsExport($transactions), 'transactions-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $transactions = Transaction::where('status', '1')->paginate(10);
                return (new TransactionsExport($transactions))->download('transactions.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {
                $transactions = Transaction::where('status', '1')->paginate(10);
            }

        } else {
            $transactions = Transaction::where('status', '1')->paginate(10);
        }
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}