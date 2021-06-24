<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use DB;
use App\Models\users;
use App\Models\visitors;
use App\Models\news;
use App\Models\warnings;
use Carbon\Carbon;

class statistics extends Controller
{
public static $model;
    function __construct(Request $request)
    {
        // self::$model=model::class;
    }
    public static function index()
    {
        $users = json_encode(self::Query('users'));
        $visitors = json_encode(self::Query('visitors'));
        $news = json_encode(self::Query('news'));
        $usersCount=users::count();
        $visitorsCount=visitors::count();
        $newsCount=news::count();
        $last_10_news= news::orderBy('id','DESC')->take(10)->get();
        $last_10_warnings= warnings::orderBy('id','DESC')->take(10)->get();
        return view('dashboard.statistics.index', compact(
            'users','visitors','news','usersCount','visitorsCount','newsCount','last_10_news','last_10_warnings'
        ));
    }   

    public static function getByDateRange(Request $request)
    {
        return response()->json([
            'usersCount'=>users::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
            'visitorsCount'=>visitors::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
            'newsCount'=>news::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
        ]);
    }

    private  static function Query($tableNAme)
    {
        return DB::table($tableNAme)
            ->select(
                DB::raw('COUNT(id) as `value`'),
                DB::raw("MONTH(createdAt) as `month`")
            )
            ->where(DB::raw("YEAR(createdAt)"), '=', date('Y'))
            ->groupBy('month')
            ->get();
    }
   
}