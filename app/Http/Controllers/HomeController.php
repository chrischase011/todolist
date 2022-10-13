<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Posts::where(['user_id' => Auth::id(), 'is_done' => ''])
        ->orWhere(['is_done' => null])->orWhere(['is_done' => 0])->orderBy('set_date', 'ASC')->paginate(5);
        return view('home', ['posts' => $posts]);
    }

    public function datesDoneIndex()
    {
        $posts = Posts::where(['user_id' => Auth::id(), 'is_done' => '1'])->orderBy('set_date', 'ASC')->paginate(5);
        return view('pages.dates_done', ['posts' => $posts]);
    }

}
