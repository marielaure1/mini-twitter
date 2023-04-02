<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweets;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            return redirect()->route('error')->with('message', 'Vous devez être connecté !');
        }

        $user = User::find(auth()->user()->id);

        if (!$user) {
            return redirect()->route('error')->with('message', 'Cet utilisateur n\'existe pas !');
        }

        $tweets = User::where("users.id", auth()->user()->id)->join('tweets', 'tweets.users_id', '=', 'users.id')
        ->orderBy("tweets.created_at", "desc")
        ->paginate(10, ["tweets.*", "users.username", "users.name"]);

        return view('dashboard', [
            'user' => $user,
            'tweets' => $tweets,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function all(string $username)
    {
        if (!auth()->user()) {
            return redirect()->route('error')->with('message', 'Vous devez être connecté !');
        }

        $user = User::where("users.username", $username)->first();

        if (!$user) {
            return redirect()->route('error')->with('message', 'Cet utilisateur n\'existe pas !');
        }

        $tweets = User::where("users.username", $username)->join('tweets', 'tweets.users_id', '=', 'users.id')
        ->orderBy("tweets.created_at", "desc")
        ->paginate(10, ["tweets.*", "users.username", "users.name"]);

        return view('user', [
            'user' => $user,
            'tweets' => $tweets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(Users $users)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Users $users)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateUsersRequest $request, Users $users)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Users $users)
    // {
    //     //
    // }
}
