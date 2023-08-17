<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Charts\SupplierChart;
use App\Charts\OrderChart;
use App\Charts\SalesChart;
use DB;
use Barryvdh\Debugbar\Facade as DebugBar;
use App\Charts\ItemChart;

class DashboardController extends Controller
{
    public function Index()
    {
        return view('customer.dashboard');
    }
    public function AdminIndex()
    {
        $supplier = DB::table('suppliers')
            ->whereNotNull('sup_address')
            ->groupBy('sup_address')
            ->orderBy('total')
            ->pluck(DB::raw('count(sup_address) as total'), 'sup_address')
            ->all();
        Debugbar::info($supplier);
        $supplierChart = new SupplierChart();
        $dataset = $supplierChart->labels(array_keys($supplier));
        $dataset = $supplierChart->dataset(
            'Supplier Demographics',
            'pie',
            array_values($supplier)
        );
        $dataset = $dataset->backgroundColor([
            '#7158e2',
            '#3ae374',
            '#ff3838',
            "#FF851B",
            "#7FDBFF",
            "#B10DC9",
            "#FFDC00",
            "#001f3f",
            "#39CCCC",
            "#01FF70",
            "#85144b",
            "#F012BE",
            "#3D9970",
            "#111111",
            "#AAAAAA",
        ]);
        // dd($supplierChart);
        $supplierChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [
                    [
                        'display' => false,
                        'ticks' => ['beginAtZero' => true],
                        'gridLines' => ['display' => false],
                    ],
                ],
                'xAxes' => [
                    [
                        'categoryPercentage' => 0.8,
                        'barPercentage' => 1,
                        'ticks' => ['beginAtZero' => false],
                        'gridLines' => ['display' => false],
                        'display' => true,
                    ],
                ],
            ],
        ]);


        $order = DB::table('orders')
            ->whereNotNull('created_at')
            ->groupBy('created_at')
            ->orderBy(DB::raw('day(created_at)'), 'ASC')
            ->pluck(
                DB::raw('count(created_at) as total'),
                DB::raw('dayname(created_at) AS day'),
            )

            ->all();


        $orderChart = new OrderChart();
        $dataset = $orderChart->labels(array_keys($order));
        $dataset = $orderChart->dataset(
            'Orders',
            'bar',
            array_values($order)
        );

        $dataset = $dataset->backgroundColor($this->bgcolor);
        $orderChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [
                    'display' => true,
                    'ticks' => ['beginAtZero' => true, 'max' => 100],
                    'min' => 0,
                    'stepSize' => 10,
                    'gridLines' => ['display' => false],
                ],
                'xAxes' => [
                    'categoryPercentage' => 0.8,
                    'barPercentage' => 1,
                    'ticks' => ['beginAtZero' => true, 'min' => 0],
                    'gridLines' => ['display' => false],
                    'display' => true,
                ],
            ],
        ]);


        $sales = DB::table('orders AS o')
            ->join('orderlines AS ol', 'o.id', '=', 'ol.orderinfo_id')
            ->join('items AS i', 'ol.item_id', '=', 'i.id')
            ->orderBy(DB::raw('day(o.created_at)'), 'ASC')
            ->groupBy('o.created_at')
            ->pluck(
                DB::raw('sum(ol.quantity * i.sellprice) AS total'),
                DB::raw('dayname(o.created_at) AS day')
            )
            ->all();


        $salesChart = new SalesChart();


        $dataset = $salesChart->labels(array_keys($sales));
        $dataset = $salesChart->dataset(
            'Daily sales',
            'line',
            array_values($sales)
        );
        $dataset = $dataset->backgroundColor($this->bgcolor);
        $dataset = $dataset->fill(false);


        $salesChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scaleBeginAtZero' => true,
            'scales' => [
                'yAxes' => [
                    [
                        'display' => true,
                        'type' => 'linear',
                        'ticks' => [
                            'beginAtZero' => true,
                            'autoSkip' => true,
                            'maxTicksLimit' => 20000,
                            'min' => 0,
                            'stepSize' => 500,
                        ],
                    ],
                    'gridLines' => ['display' => false],
                ],
                'xAxes' => [
                    'categoryPercentage' => 0.8,
                    'barPercentage' => 1,
                    'gridLines' => ['display' => false],
                    'display' => true,
                    'ticks' => [
                        'beginAtZero' => true,
                        'min' => 0,
                        'stepSize' => 10,
                    ],
                ],
            ],
        ]);


        $items = DB::table('stocks AS st')
        ->join('items AS i', 'st.item_id', '=', 'i.id')
        ->groupBy('i.item_name')
        ->orderBy('total', 'DESC')
        ->pluck(DB::raw('sum(st.quantity) AS total'), 'item_name')
        ->all();



        $itemChart = new ItemChart();

        $dataset = $itemChart->labels(array_keys($items));
        $dataset = $itemChart->dataset(
            'Stock Quantity',
            'bar',
            array_values($items)
        );

        $dataset = $dataset->backgroundColor($this->bgcolor);
        $dataset = $dataset->fill(false);
        $itemChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,


            'scales' => [
                'yAxes' => [
                    'display' => true,
                    'ticks' => ['beginAtZero' => true],
                    'gridLines' => ['display' => false],
                ],
                'xAxes' => [
                    'categoryPercentage' => 0.8,
                    'barPercentage' => 1,


                    'gridLines' => ['display' => false],
                    'display' => true,
                    'ticks' => [
                        'beginAtZero' => true,
                        'min' => 0,
                        'stepSize' => 10,
                    ],
                ],
            ],
        ]);


        return view(
            'admin.dashboard',
            compact('supplierChart', 'orderChart', 'salesChart', 'itemChart')
        );

    }

    public function __construct()
    {
        $this->bgcolor = collect([
            '#7158e2',
            '#3ae374',
            '#ff3838',
            "#FF851B",
            "#7FDBFF",
            "#B10DC9",
            "#FFDC00",
            "#001f3f",
            "#39CCCC",
            "#01FF70",
            "#85144b",
            "#F012BE",
            "#3D9970",
            "#111111",
            "#AAAAAA",
        ]);
    }
    public function index2()
    {


    }
}
