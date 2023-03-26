<?php

namespace App\Http\Controllers;

use App\Models\Tweets;
use App\Http\Requests\StoreTweetsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateTweetsRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\View\View;

class TweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all(): View
    {
        $tweets = Tweets::join('users', 'tweets.users_id', '=', 'users.id')
        ->orderBy("tweets.created_at", "desc")
        ->paginate(10, ["tweets.*", "users.username", "users.name"]);

        return view('timeline', [
            'tweets' => $tweets,
        ]);
    }
    

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create(StoreTweetsRequest $request): RedirectResponse
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTweetsRequest $request):  RedirectResponse
    {
        $validated = $request->validated();

        if (!$validated) {
            return redirect()->back()->with('status', 'envoye');
        }

        if (!auth()->user()) {
            return RedirectResponse::route('error')->with('status', 'Vous devez être connecté');
        }

        $newTweet = Tweets::create([
            'content' => $request->content,
            'users_id' => auth()->user()->id
        ]);
        $newTweet->save();

        return redirect()->back()->with('status', 'Votre tweet à bien été publié.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweets $tweets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweets $tweets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTweetsRequest $request, Tweets $tweets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Tweets $tweets)
    {
        if (!auth()->user()) {
            return redirect()->route('error')->with('message', 'Vous devez être connecté !');
        }

        $tweet = Tweets::find($request->id);

        if (!$tweet) {
            return redirect()->route('error')->with('message', 'Ce tweet n\'existe plus !');
        }

        if (auth()->user()->id != $tweet->users_id) {
            return redirect()->route('error')->with('message', 'Ce tweet ne vous appartient pas, vous ne pouvez pas le supprimer !');
        }

        $delete = $tweet->delete();

        if (!$delete) {
            return redirect()->back()->with('message', 'Ce tweet n\'a pas pu être supprimé !');
        }

        return redirect()->back()->with('status', 'Votre tweet à bien été supprimé.');
    }
}
