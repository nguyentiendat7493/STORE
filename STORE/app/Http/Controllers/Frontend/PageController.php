<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(Page $page): View
    {
        abort_if(! $page->published()->whereKey($page->id)->exists(), 404);

        return view('pages.show', compact('page'));
    }
}
