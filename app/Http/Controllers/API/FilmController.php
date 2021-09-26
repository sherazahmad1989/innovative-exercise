<?php

namespace App\Http\Controllers\API;

use App\Models\Film;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FilmController extends BaseController
{
    use FileUploadTrait;

    /**
     * @return Response
     */
    public function index()
    {
        $film = Film::with('comments')->get();
        return $this->sendResponse($film, 'Film retrieved successfully.');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'release_date' => 'required',
            'rating' => 'required',
            'ticket_price' => 'required',
            'country' => 'required',
            'photo' => 'required',
        ]);
        $film = new Film();
        $film->name = $request->name;
        $film->description = $request->description;
        $film->release_date = $request->release_date;
        $film->rating = $request->rating;
        $film->ticket_price = $request->ticket_price;
        $film->country = $request->country;
        $film->photo = $this->uploadFileFromBase64($request->photo);
        $film->save();
        return $this->sendResponse($film, 'Film Save successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $film = Film::with('comments')->where('id', $id)->first();
        return $this->sendResponse($film, 'Film retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'release_date' => 'required',
            'rating' => 'required',
            'ticket_price' => 'required',
            'country' => 'required',
            'photo' => 'required',
        ]);
        $film = Film::find($id);
        $film->name = $request->name;
        $film->description = $request->description;
        $film->release_date = $request->release_date;
        $film->rating = $request->rating;
        $film->ticket_price = $request->ticket_price;
        $film->country = $request->country;
        $filmSave = $film->save();
        return $this->sendResponse($film, 'Film Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $film = Film::find($id);
        $film->comments()->delete();
        $deleteFilm = $film->delete(); //returns true/false
        return $this->sendResponse($film, 'Film Deleted successfully.');
    }
}
