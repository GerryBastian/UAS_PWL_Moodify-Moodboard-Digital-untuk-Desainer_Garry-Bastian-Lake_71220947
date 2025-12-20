<?php

namespace App\Http\Controllers;

use App\Models\Moodboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MoodboardController extends Controller
{
    public function home(Request $request)
    {
        $query = Moodboard::query();

        // 🔍 Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('creator', 'like', "%{$search}%");
            });
        }

        // 🎨 Filter by theme
        if ($request->filled('theme') && $request->theme !== 'all' && $request->theme !== '') {
            $query->where('theme', $request->theme);
        }

        $moodboards = $query->withCount('favorites')->latest()->paginate(9)->appends($request->query());

        return view('moodboards.index', [
            'moodboards' => $moodboards,
            'themes' => $this->themes,
            'sort' => 'random',
            'context' => 'discovery'
        ]);
    }

    private $themes = ['minimalist', 'retro', 'dreamy', 'nature'];

    public function index(Request $request)
    {
        $query = Moodboard::query();

        // 🔍 Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('creator', 'like', "%{$search}%");
            });
        }

        // 🎨 Filter by theme
        if ($request->filled('theme') && $request->theme !== 'all' && $request->theme !== '') {
            $query->where('theme', $request->theme);
        }

        // 🔽 Sorting logic - DEFAULT: newest (data terbaru muncul paling depan)
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'za':
                $query->orderBy('title', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc'); // Data terbaru di depan
        }

        $moodboards = $query->get();

        return view('moodboards.index', [
            'moodboards' => $moodboards,
            'themes' => $this->themes,
            'sort' => $sort,
            'context' => 'management'
        ]);
    }

    public function create()
    {
        return view('moodboards.create', ['themes' => $this->themes]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'theme' => 'required|in:' . implode(',', $this->themes),
            'creator' => 'required|string|max:255',
            'color_key_1' => 'required|string|size:7|starts_with:#',
            'color_key_2' => 'required|string|size:7|starts_with:#',
            'color_key_3' => 'required|string|size:7|starts_with:#',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('moodboard_images', 'public');
        }

        $validated['code'] = 'MD-' . strtoupper(uniqid());
        Moodboard::create($validated);

        return redirect()->route('moodboards.index')->with('success', 'Moodboard berhasil dibuat!');
    }

    public function show(Moodboard $moodboard)
    {
        return view('moodboards.show', compact('moodboard'));
    }

    public function toggleFavorite(Moodboard $moodboard)
    {
        $user = auth()->user();
        if ($user->favorites()->where('moodboard_id', $moodboard->id)->exists()) {
            $user->favorites()->detach($moodboard->id);
            $message = 'Removed from favorites';
        } else {
            $user->favorites()->attach($moodboard->id);
            $message = 'Added to favorites';
        }

        return back()->with('success', $message);
    }

    public function edit(Moodboard $moodboard)
    {
        return view('moodboards.edit', [
            'moodboard' => $moodboard,
            'themes' => $this->themes
        ]);
    }

    public function update(Request $request, Moodboard $moodboard)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'theme' => 'required|in:' . implode(',', $this->themes),
            'creator' => 'required|string|max:255',
            'color_key_1' => 'required|string|size:7|starts_with:#',
            'color_key_2' => 'required|string|size:7|starts_with:#',
            'color_key_3' => 'required|string|size:7|starts_with:#',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika bukan default image
            if ($moodboard->image_path && $moodboard->image_path !== 'moodboard_images/no-image.jpg' && Storage::disk('public')->exists($moodboard->image_path)) {
                Storage::disk('public')->delete($moodboard->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('moodboard_images', 'public');
        }

        $moodboard->update($validated);

        return redirect()->route('moodboards.index')->with('success', 'Moodboard berhasil diupdate!');
    }

    public function destroy(Moodboard $moodboard)
    {
        // Hapus gambar jika bukan default image
        if ($moodboard->image_path && $moodboard->image_path !== 'moodboard_images/no-image.jpg' && Storage::disk('public')->exists($moodboard->image_path)) {
            Storage::disk('public')->delete($moodboard->image_path);
        }

        $moodboard->delete();

        return redirect()->route('moodboards.index')->with('success', 'Moodboard berhasil dihapus!');
    }
}
