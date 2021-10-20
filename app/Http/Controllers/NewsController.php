<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getList()
    {
        $news = News::query()
            ->where('published_at', '<=', now())
            ->where('is_published', true)
            ->orderByRaw("published_at DESC, id DESC")
            ->paginate(5);

        return view('news_list', ['news' => $news]);
    }

    public function getDetails(string $slug)
    {
        $news = News::where('slug', $slug)
            ->where('published_at', '<=', now())
            ->where('is_published', true)
            ->first();

        if ($news === null) {
            abort(404);
        }
        return view('news_item', ['news' => $news]);
    }
}
