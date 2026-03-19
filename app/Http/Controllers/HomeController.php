<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    const PER_PAGE_PAGINATE = 6;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Home', [
            'title' => 'Главная'
        ]);
    }

    public function video_list(Request $request)
    {
        $data = $request->all();

        if(!empty($data)) {
            [$videos, $filters] = $this->filter($request);
        }
        else {
            $videos = Video::query()->orderBy('created_at', 'desc')->paginate(static::PER_PAGE_PAGINATE);
        }

        return Inertia::render('Video/VideoList', [
            'title' => 'Медиа',
            'videos' => $videos,
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'filters' => $filters ?? null
        ]);
    }

    public function video_item(Video $video)
    {
        $video->loadMissing(['category']);

        return Inertia::render('Video/VideoItem', [
            'title' => $video->title,
            'video' => $video
        ]);
    }

    public function filter(Request $request)
    {
        $query = Video::query();
        $sortColumnsName = ['title', 'created_at'];
        $sortBy = ['asc', 'desc'];

        if ($request->has('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('tags')) {
            $tagIds = explode(',', $request->tags);
            $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $tagIds));
        }

        if ($request->has('sort')) {
            [$field, $direction] = explode(':', $request->sort);
            if(in_array($field, $sortColumnsName) && in_array($direction, $sortBy)) {
                $query->orderBy($field, $direction);
            }
        }
        else {
            $query->orderBy('created_at', 'desc');
        }

        $videos = $query->paginate(self::PER_PAGE_PAGINATE)->withQueryString();

        return [
            $videos,
            $request->only(['search', 'category', 'tags', 'sort'])
        ];
    }
}
