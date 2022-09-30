<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    // Pages

    public function addNewListIndex()
    {
        return view('pages.add_new_list');
    }

 

    // Functions

    public function addNewList(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'set_date' => 'nullable',
        ]);

        $post = Posts::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'set_date' => $request->set_date,
        ]);

        if($post)
            return redirect()->intended(route('home'));

        return throw new Exception('Could not add new list. Please contact web master.');
    }

    public function getListById(Request $request)
    {
        $posts = Posts::findOrFail($request->id);
        return json_encode($posts);
    }

    public function editList(Request $request)
    {
        $post = Posts::findOrFail($request->id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->set_date = $request->set_date;
        $post->save();

        return redirect()->intended('/');
    }

    public function markAsDone(Request $request)
    {
        $post = Posts::findOrFail($request->id);
        $post->is_done = '1';
        $post->save();


        return 1;
    }

    public function markAsNotDone(Request $request)
    {
        $post = Posts::findOrFail($request->id);
        $post->is_done = '';
        $post->save();

        return 1;
    }

    public function deleteList(Request $request)
    {
        $post = Posts::findOrFail($request->id);
        $post->delete();

        return 1;
    }
}
