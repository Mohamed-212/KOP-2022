<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\FrontController;
use App\Http\Controllers\Controller;
use App\Models\News;
use AWS\CRT\HTTP\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function AllBlogs()
    {
        $common = $this->common();
        $archives = $common[0];
        $latest = $common[1];
        $return = (app(FrontController::class)->getAllNews())->getOriginalContent();
        foreach ($return as $in => $re) {
            if ($in == 'data') {
                $articles = $re;
                return view('website.page-blog', compact(['articles', 'archives', 'latest']));
            }
        }
    }
    public function Blog($id)
    {
        $prev = News::find($id - 1);
        $next = News::find($id + 1);

        $common = $this->common();
        $archives = $common[0];
        $latest = $common[1];

        $return = (app(FrontController::class)->getNew($id))->getOriginalContent();
        foreach ($return as $in => $re) {
            if ($in == 'data') {
                $article = $re;
                return view('website.page-blog-article', compact(['article', 'latest', 'prev', 'next', 'archives']));
            }
        }
    }

    public function blogsArchive(int $year, string $month)
    {
        $common = $this->common();
        $archives = $common[0];
        $latest = $common[1];

        $articles = News::where(DB::raw("DATE_FORMAT(updated_at, '%m-%Y')"), "$month-$year")->simplePaginate();

        return view('website.page-blog', compact(['articles', 'archives', 'latest']));
    }

    private function common()
    {
        $archives = DB::table('news')
            ->select([DB::raw("DATE_FORMAT(updated_at, '%m-%Y') new_date"),  DB::raw('YEAR(updated_at) year, MONTH(updated_at) month')])
            ->groupBy('year', 'month')
            ->orderBy('updated_at')
            ->get();
        $latest = News::latest()->limit(4)->get();

        return [$archives, $latest];
    }
}
