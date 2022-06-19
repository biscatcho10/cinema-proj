<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Filters\FilmsFilter;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{

    public function __construct(FilmsFilter $filter)
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
        $films = Film::filter($this->filter)->paginate(request()->per_page, ['*'], 'page', request()->page);

        return response()->json([
            'success' => true,
            'message' => 'films list.',
            'data' => $films
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
            'image' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $input['image'] = $this->saveImage($request->image);
        }

        $film = Film::create($input);

        return response()->json([
            'success' => true,
            'message' => 'film created Successfully.',
            'data' => $film
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show(Film $film)
    {
        return response()->json([
            'success' => true,
            'message' => 'film show.',
            'data' => $film
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Film $film)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $input['image'] = $this->saveImage($request->image);
        }

        $film->update($input);

        return response()->json([
            'success' => true,
            'message' => 'film updated Successfully.',
            'data' => $film
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {
        $film->delete();

        return response()->json([
            'success' => true,
            'message' => 'film deleted Successfully.',
            'data' => $film
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
        $path = $folderPath . $file;
        file_put_contents($path, $image_base64);
        return $file;
    }
}
