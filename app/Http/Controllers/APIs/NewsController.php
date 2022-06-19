<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Filters\NewsFilter;
use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function __construct(NewsFilter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::filter($this->filter)->paginate(request()->per_page, ['*'], 'page', request()->page);

        return response()->json([
            'success' => true,
            'message' => 'news list.',
            'data' => $news
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required',
            'category_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $input = $request->all();
        // save image
        if ($request->image) {
            $input["image"] = $this->saveImage($request->image);
        }

        if ($request->date) {
            $input["date"] = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        }

        $news = News::create($input);

        return response()->json([
            'success' => true,
            'message' => 'news created.',
            'data' => $news
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return response()->json([
            'success' => true,
            'message' => 'news show.',
            'data' => $news
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required',
            'category_id' => 'required|integer',
        ]);

        $input = $request->all();
        // save image
        if ($request->image) {
            $input["image"] = $this->saveImage($request->image);
        }

        if ($request->date) {
            $input["date"] = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        }

        $news->update($input);

        return response()->json([
            'success' => true,
            'message' => 'news updated.',
            'data' => $news
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'news deleted.',
            'data' => $news
        ], 200);
    }


    // get category news
    public function category(Category $category)
    {
        $news = $category->news()->paginate(request()->per_page, ['*'], 'page', request()->page);

        return response()->json([
            'success' => true,
            'message' => 'news list.',
            'data' => $news
        ], 200);
    }


    // save base64 image
    public function saveImage($image)
    {
        $folderPath = "storage/"; //path location
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $uniqid = uniqid();
        $file = $uniqid . '.' . $image_type;
        $path = $folderPath .$file;
        file_put_contents($path, $image_base64);
        return $file;
    }

}
