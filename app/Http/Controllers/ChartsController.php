<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Charts\SupplierChart;
use App\Charts\TownChart;
use App\Charts\SalesChart;
use App\Charts\ItemChart;
use Barryvdh\Debugbar\Facade as DebugBar;
use DB;


class ChartsController extends Controller
{
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
    public function index()
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


        $town = DB::table('customers')
            ->whereNotNull('address')
            ->groupBy('address')
            ->orderBy('address', 'ASC')
            ->pluck(DB::raw('count(address) as total'), 'address')
            ->all();


        $townChart = new TownChart();
        $dataset = $townChart->labels(array_keys($town));
        $dataset = $townChart->dataset(
            'town Demographics',
            'bar',
            array_values($town)
        );
   
        $dataset = $dataset->backgroundColor($this->bgcolor);
        $townChart->options([
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


        $items = DB::table('orderlines AS ol')
        ->join('items AS i', 'ol.item_id', '=', 'i.id')
        ->groupBy('i.sellprice')
        ->orderBy('total', 'DESC')
        ->pluck(DB::raw('sum(ol.quantity) AS total'), 'sellprice')
        ->all();



        $itemChart = new ItemChart();
       
        $dataset = $itemChart->labels(array_keys($items));
        $dataset = $itemChart->dataset(
            'Item sold',
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
            'dashboard.index',
            compact('supplierChart', 'townChart', 'salesChart', 'itemChart')
        );
    }
}
