<?php

namespace App\Http\Controllers;

use DB;

use App\DailyZoneDeliverymanCombo;
use App\DailySheet;
use App\AccClientTransaction;
use App\Brand;
use App\Client;
use App\AccBrandTotal;
use App\AccBrandTransaction;
use App\AccDailyBrandTransaction;
use App\Product;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report_daily_sheet_index()
    {
        $daily_sheets = DailyZoneDeliverymanCombo::with(['zone', 'delivery_man', 'brand'])->orderBy('created_at', 'desc')->orderBy('brand_id')->paginate(15);

        return view('reports/dailysheetindex', compact('daily_sheets'));
    }

    public function report_daily_sheet_details($id)
    {
        $sheet_details = DailyZoneDeliverymanCombo::where('id', $id)->with(['zone', 'delivery_man', 'brand'])->get();
        $product_details = DailySheet::where('daily_zone_delivery_man_combo_id', $id)->with(['product'])->orderBy('product_id')->get();
        $dues = AccClientTransaction::where('daily_zone_deliveryman_id', $id)->with('client')->get();
        return view('reports/dailysheetdetails', compact('sheet_details', 'product_details', 'dues'));
    }

    public function report_daily_brand_transaction_index()
    {
        $brands = AccBrandTotal::with('brand')->get();

        return view('/reports/dailybrandtransactionsindex', compact('brands'));
    }

    public function report_daily_brand_final_count($id)
    {
        $final_counts = AccDailyBrandTransaction::where([['brand_id', '=', $id], ['date', '=', Carbon::today()]])->with('brand')->get();
        if (count($final_counts) == 1) {
            return view('/reports/dailybrandfinalcount', compact('final_counts'));
        } else {
            $no_data = Brand::where('id', '=', $id)->get();
            return view('/reports/nodatafound', compact('no_data'));
        }
    }

    public function report_daily_brand_final_count_by_date(Request $request)
    {
        $data = $request->all();

        $final_counts = AccDailyBrandTransaction::where([['brand_id', '=', $data['brand_id']], ['date', '=', $data['date']]])->with('brand')->get();
        if (count($final_counts) == 1) {
            return view('/reports/dailybrandfinalcount', compact('final_counts'));
        } else {
            $no_data = Brand::where('id', '=', $data['brand_id'])->get();
            return view('/reports/nodatafound', compact('no_data'));
        }
    }

    public function report_daily_brand_final_count_by_date_search(Request $request)
    {
        $date = $request->get('search_date');
        $id = $request->get('brand_id');
        $final_counts = AccDailyBrandTransaction::where([['brand_id', '=', $id], ['date', '=', $date]])->with('brand')->get();
        if (count($final_counts) == 1) {
            return view('/reports/dailybrandfinalcount', compact('final_counts'));
        } else {
            $no_data = Brand::where('id', '=', $id)->get();
            return view('/reports/nodatafound', compact('no_data'));
        }
    }

    public function report_daily_brand_due($id)
    {
        $transactions_due = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $id], ['transactions.transaction_type', '=', 'Due']])
            ->whereDate('transactions.created_at', '=', Carbon::today())
            ->get();
        $brand = Brand::where('id', $id)->get();
        $date = Carbon::today()->toDateString();
        return view('/reports/reportdailybranddue', compact('transactions_due', 'brand', 'date'));
    }

    public function report_daily_brand_due_by_date_search(Request $request)
    {
        $brand = $request->get('brand_id');
        $date = $request->get('search_date');

        $transactions_due = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $brand], ['transactions.transaction_type', '=', 'Due']])
            ->whereDate('transactions.created_at', '=', $date)
            ->get();
        $brand = Brand::where('id', $brand)->get();
        return view('/reports/reportdailybranddue', compact('transactions_due', 'brand', 'date'));
    }

    public function report_daily_brand_payment($id)
    {
        $transactions_payment = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $id], ['transactions.transaction_type', '=', 'Paid']])
            ->whereDate('transactions.created_at', '=', Carbon::today())
            ->get();
        $brand = Brand::where('id', $id)->get();
        $date = Carbon::today()->toDateString();
        return view('/reports/reportdailybrandpayment', compact('transactions_payment', 'brand', 'date'));
    }

    public function report_daily_brand_payment_by_date_search(Request $request)
    {
        $brand = $request->get('brand_id');
        $date = $request->get('search_date');

        $transactions_payment = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $brand], ['transactions.transaction_type', '=', 'Paid']])
            ->whereDate('transactions.created_at', '=', $date)
            ->get();
        $brand = Brand::where('id', $brand)->get();
        return view('/reports/reportdailybrandpayment', compact('transactions_payment', 'brand', 'date'));
    }

    public function report_daily_brand_transaction($id)
    {
        $transactions_due = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $id], ['transactions.transaction_type', '=', 'Paid']])
            ->whereDate('transactions.created_at', '=', Carbon::today())
            ->get();

        $transactions_payment = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $id], ['transactions.transaction_type', '=', 'Due']])
            ->whereDate('transactions.created_at', '=', Carbon::today())
            ->get();

        $brand = Brand::where('id', $id)->get();
        $date = Carbon::today()->toDateString();
        return view('/reports/reportdailybrandtransaction', compact('transactions_due', 'transactions_payment', 'brand', 'date'));
    }

    public function report_daily_brand_transaction_by_date_search(Request $request)
    {
        $brand = $request->get('brand_id');
        $date = $request->get('search_date');

        $transactions_due = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $brand], ['transactions.transaction_type', '=', 'Paid']])
            ->whereDate('transactions.created_at', '=', $date)
            ->get();

        $transactions_payment = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $brand], ['transactions.transaction_type', '=', 'Due']])
            ->whereDate('transactions.created_at', '=', $date)
            ->get();

        $brand = Brand::where('id', $brand)->get();
        return view('/reports/reportdailybrandtransaction', compact('transactions_due', 'transactions_payment', 'brand', 'date'));
    }

    public function report_brand_transaction($id)
    {
        $transactions = AccBrandTransaction::where('brand_id', $id)
            ->with(['brand'])->get();

        $brand = Brand::where('id', $id)->get();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        return view('/reports/reportbrandtransaction', compact('transactions', 'brand', 'month', 'year'));
    }

    public function report_brand_transaction_by_date_search(Request $request)
    {
        $id = $request->get('brand_id');
        $month = $request->get('month');
        $year = $request->get('year');

        $transactions = AccBrandTransaction::where('brand_id', $id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with(['brand'])->get();

        $brand = Brand::where('id', $id)->get();

        return view('/reports/reportbrandtransaction', compact('transactions', 'brand', 'month', 'year'));
    }

    public function report_client_transaction_index()
    {
        return view('/reports/reportclienttransaction');
    }

    public function report_client_transaction_details(Request $request)
    {
        $id = $request->get('client_id');

        $transactions = AccClientTransaction::where('client_id', $id)->get();

        return response()->json($transactions);
    }

    public function inventory_report_index()
    {
        $brands = AccBrandTotal::with('brand')->get();

        return view('/reports/inventoryreportindex', compact('brands'));
    }

    public function inventory_report_details($id)
    {
        $products = Product::where('brand_id', $id)->with(['stocks', 'brand'])->get();
        $totals = AccBrandTotal::where('brand_id', $id)->get();

        return view('/reports/inventoryreportdetails', compact('products', 'totals'));
    }


    public function due_report_details($id)
    {
        $transactions = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where('brands.id', '=', $id)
            ->select(
                'transactions.id as id',
                'clients.id as client_id',
                'clients.client_name as client_name',
                'transactions.transaction_type as type',
                'transactions.transaction_amount as amount'
            )
            ->get();

        $clients = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where('brands.id', '=', $id)
            ->select('transactions.client_id', 'clients.client_name as client_name')
            ->distinct()
            ->get();

        $brand = Brand::where('id', '=', $id)->get();
        $counter = count($transactions);
        $counter2 = count($clients);

        // return $transactions;
        return view('/reports/duereportdetails', compact('brand', 'transactions', 'counter', 'clients', 'counter2'));
    }

    public function due_report_details_2($id)
    {
        $sql = "SELECT DISTINCT sr.client_id, clients.client_name,
            (select SUM(sr2.transaction_amount)
                from acc_client_transactions sr2
                where sr2.brand_id = $id AND sr2.client_id = sr.client_id AND sr2.transaction_type = 'Paid'
            ) as paid,
            (select SUM(sr2.transaction_amount)
                from acc_client_transactions sr2
                where sr2.brand_id = $id AND sr2.client_id = sr.client_id AND sr2.transaction_type = 'Due'
            ) as due
            FROM  acc_client_transactions as sr
            LEFT JOIN clients as clients ON sr.client_id = clients.id
            WHERE sr.brand_id = $id";

        $clients = DB::select(DB::raw($sql));
        $brand = Brand::where('id', '=', $id)->first();

        return view('reports.new', compact('clients', 'brand'));
        //return $clients;
    }

    public function client_transaction_details($client_id, $brand_id)
    {
        $transactions = DB::table('acc_client_transactions as transactions')
            ->join('daily_zone_deliveryman_combos as combos', 'combos.id', '=', 'transactions.daily_zone_deliveryman_id')
            ->join('brands', 'combos.brand_id', '=', 'brands.id')
            ->join('clients', 'transactions.client_id', '=', 'clients.id')
            ->where([['brands.id', '=', $brand_id], ['transactions.client_id', '=', $client_id]])
            ->select(
                'transactions.id as id',
                'clients.id as client_id',
                'clients.client_name as client_name',
                'transactions.transaction_type as type',
                'transactions.transaction_amount as amount'
            )
            ->get();

        $brand = Brand::where('id', '=', $brand_id)->first();
        $client = Client::where('id', '=', $client_id)->first();

        return view('/reports/clienttransactiondetails', compact('transactions', 'brand', 'client'));
    }
}
