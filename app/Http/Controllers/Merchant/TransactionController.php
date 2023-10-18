<?php

namespace App\Http\Controllers\Merchant;

use App\Charts\TransactionsChart;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $searchTerm = request('search');
        $status = request('status', 'success');

        $transactionsQuery = Transaction::with('merchant');

        if ($user->hasRole('merchant')) {
            $transactionsQuery->where('merchant_id', $user->merchant_id);
        } elseif ($user->hasRole('admin') && request()->filled('merchant_id')) {
            $transactionsQuery->where('merchant_id', request('merchant_id'));
        }

        if ($status && ($status != 'all')) {
            $transactionsQuery->where('status', $status);
        }

        $transactions = $transactionsQuery->with('merchant')
            ->filter()
            ->orderBy('created_at', 'desc')

            ->paginate(50);

        $merchants = $user->hasRole('admin') ? Merchant::all() : null;

        // Calculate the sum of the amount column
        $totalAmount = $transactionsQuery->sum('amount');

        return view('merchants.transactions.index', compact('transactions', 'searchTerm', 'merchants', 'totalAmount'))->withInput(request()->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $transactionQuery = Transaction::query()
            ->select(
                DB::raw('COUNT(*) AS total_transaction_count'),
                DB::raw('DATE(created_at) AS transaction_date'),
                DB::raw('SUM(amount) AS total_amount'),
                DB::raw('COUNT(*) AS transaction_count')
            );

        if ($user->hasRole('merchant')) {
            $transactionQuery->where('merchant_id', $user->merchant_id);
        } elseif ($user->hasRole('admin') && request()->filled('merchant_id')) {
            $transactionQuery->where('merchant_id', request('merchant_id'));
        }

        if (request()->input('start_date') && request()->input('end_date')) {
            $validatedData = request()->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            $transactionQuery->whereBetween('created_at', $validatedData);
        }

        $transactionQuery->where('status', 'success');

        switch ($request->input('timeRange')) {
            case 'today':
                $transactionQuery->ofToday();
                break;

            case 'lastWeek':
                $transactionQuery->ofLast7Days();
                break;

            case 'lastTwoWeeks':
                $transactionQuery->ofLast14Days();
                break;

            case 'lastMonth':
                $transactionQuery->ofLastMonth();
                break;
            default:
                $transactionQuery->ofLast14Days();
                break;
        }

        $transactionQuery->groupBy('transaction_date');

        $transactionDate = $transactionQuery->pluck('transaction_date');

        $transactionAmount = $transactionQuery->pluck('total_amount');

        $results = $transactionQuery->get();

        $transactionCount = $results->sum('total_transaction_count');
        $totalTransaction = $results->sum('total_amount');

        $merchants = $user->hasRole('admin') ? Merchant::all() : null;

        $chart = new TransactionsChart;
        $chart->labels($transactionDate);
        $chart->dataset('Amount', 'line', $transactionAmount);
        $chart->dataset('Count', 'line', $transactionQuery->pluck('transaction_count'));

        return view('merchants.dashboard.index', compact('chart', 'transactionCount', 'totalTransaction', 'merchants'));
    }
}
