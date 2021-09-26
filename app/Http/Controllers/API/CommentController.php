<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'film_id' => 'required'
        ]);
        $request->request->add(['user_id' => $request->user()->id]);
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;
        $comment->film_id = $request->film_id;
        $comment->save();
        return $this->sendResponse($comment, 'comment successfully.');
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
            'comment' => 'required',
            'film_id' => 'required'
        ]);
        $request->request->add(['user_id' => $request->user()->id]);
        $comment = find($id);
        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;
        $comment->film_id = $request->film_id;
        $comment->save();
        return $this->sendResponse($comment, 'comment successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        $deleteFilm = $comment->delete(); //returns true/false
        return $this->sendResponse($comment, 'Film Deleted successfully.');
    }
}
