<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melihat bookmark.');
        }

        $userId = Auth::id();
        $bookmarks = Bookmark::with('movie')
            ->where('user_id', $userId)
            ->paginate(10);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        try {
            // Cek apakah user sudah login
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu untuk menambahkan film ke bookmark.',
                    'redirect' => route('movie-picker.result') . '?error=login_required'
                ]);
            }

            $request->validate([
                'movie_id' => 'required|exists:movies,id'
            ]);

            $userId = Auth::id();
            $movieId = $request->movie_id;

            // Check if already bookmarked
            $existingBookmark = Bookmark::where('user_id', $userId)
                ->where('movie_id', $movieId)
                ->first();

            if ($existingBookmark) {
                return response()->json([
                    'success' => false,
                    'message' => 'Film sudah ada di bookmark Anda!',
                    'redirect' => route('movie-picker.result') . '?info=already_bookmarked'
                ]);
            }

            // Create new bookmark
            Bookmark::create([
                'user_id' => $userId,
                'movie_id' => $movieId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Film berhasil ditambahkan ke bookmark!',
                'redirect' => route('movie-picker.result') . '?success=bookmark_added'
            ]);

        } catch (\Exception $e) {
            \Log::error('Bookmark store error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('movie-picker.result') . '?error=system_error'
            ], 500);
        }
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = Auth::id();

        $bookmark = Bookmark::with('movie')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('bookmarks.edit', compact('bookmark'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();

        $bookmark = Bookmark::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $bookmark->update([
            'notes' => $request->notes
        ]);

        return redirect()->route('bookmarks.index')->with('success', 'Bookmark berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu'
                ]);
            }

            $userId = Auth::id();

            $bookmark = Bookmark::where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if ($bookmark) {
                $bookmark->delete();
                return redirect()->back()->with('success', 'Bookmark berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Bookmark tidak ditemukan.');

        } catch (\Exception $e) {
            \Log::error('Bookmark destroy error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus bookmark.');
        }
    }

    public function check($movieId)
    {
        if (!Auth::check()) {
            return response()->json(['bookmarked' => false]);
        }

        $userId = Auth::id();

        $exists = Bookmark::where('movie_id', $movieId)
            ->where('user_id', $userId)
            ->exists();

        return response()->json(['bookmarked' => $exists]);
    }
}
