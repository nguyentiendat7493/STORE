<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReviewController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $reviews = Review::query()
            ->with(['user', 'product', 'order'])
            ->search($request->string('q')->toString())
            ->filter($request->only(['product_id', 'user_id', 'rating', 'status']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Request $request, Review $review): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $review->load(['user', 'product', 'order']);

        return view('admin.reviews.show', compact('review'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,hidden'],
        ]);

        $review->update($data);

        return back()->with('success', 'Review status updated.');
    }

    public function destroy(Request $request, Review $review): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted.');
    }
}
