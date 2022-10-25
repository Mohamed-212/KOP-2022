<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\FrontController;
use App\Http\Controllers\Controller;
use App\Models\HealthInfo as ModelsHealthInfo;
use App\Models\News;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class HealthInfo extends Controller
{
    public function Infos(){
        $articles = ModelsHealthInfo::paginate();
        $health = true;
        $common = $this->common();
        $archives = $common[0];
        $latest = $common[1];
        return view('website.page-blog',compact(['articles', 'health', 'archives', 'latest']));
    }

    public function show($id)
    {
        $article = ModelsHealthInfo::find($id);
        $prev = ModelsHealthInfo::find($id - 1);
        $next = ModelsHealthInfo::find($id + 1);

        $common = $this->common();
        $archives = $common[0];
        $latest = $common[1];
        $health = true;


        return view('website.page-blog-article', compact(['article', 'prev', 'next', 'archives', 'latest', 'health']));
    }

    public function infosArchive(int $year, string $month)
    {
        $common = $this->common();
        $archives = $common[0];
        $latest = $common[1];
        $health = true;

        $articles = ModelsHealthInfo::where(DB::raw("DATE_FORMAT(updated_at, '%m-%Y')"), "$month-$year")->simplePaginate();

        return view('website.page-blog', compact(['articles', 'archives', 'latest', 'health']));
    }

    private function common()
    {
        $archives = DB::table('health_infos')
            ->select([DB::raw("DATE_FORMAT(updated_at, '%m-%Y') new_date"),  DB::raw('YEAR(updated_at) year, MONTH(updated_at) month')])
            ->groupBy('year', 'month')
            ->orderBy('updated_at')
            ->whereNull('deleted_at')
            ->get();
        $latest = ModelsHealthInfo::latest()->limit(4)->get();

        return [$archives, $latest];
    }
}
