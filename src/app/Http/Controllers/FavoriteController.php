<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Item $item)
    {
        Favorite::favorite(Auth::id(), $item->id);
        return redirect()->back();
    }
    public function destroy(Item $item)
    {
        Favorite::where('user_id', Auth::id())->where('item_id', $item->id)->delete();
        return redirect()->back();
    }
}
