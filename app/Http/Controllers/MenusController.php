<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenusRequest;
use App\Http\Resources\MenusResource;
use App\Models\Menus;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    // menampilkan semua menu
    public function index()
    {
        return response()->json(MenusResource::collection(Menus::all()), 200);
    }

    // menampilkan menu berdasarkan ID
    public function getMenuById($id)
    {
        $menu = Menus::find($id);
        if ($menu) {
            return response()->json(new MenusResource($menu), 200);
        } else {
            return response()->json(['message' => 'Menu not found'], 404);
        }
    }

    // Menampilkan menu yang rekomendasi
        public function getRecommended()
    {
        $recommendedMenus = Menus::where('rekomendasi', true)->get();

        if ($recommendedMenus->isEmpty()) {
            return response()->json(['message' => 'No recommended menus found'], 404);
        }

        return response()->json(MenusResource::collection($recommendedMenus), 200);
    }



    // menambahkan menu baru
    public function store(StoreMenusRequest $request)
    {
        $validated = $request->validated();

        // Normalize input rekomendasi
        $validated['rekomendasi'] = $request->boolean('rekomendasi');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
            $validated['image'] = $imagePath;
        }

        $menu = Menus::create($validated);

        return response()->json(new MenusResource($menu), 201);
    }


    // mengupdate data menu tertentu
    public function update(StoreMenusRequest $request, $id)
    {
        $menu = Menus::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $validated = $request->validated();

        // Cek apakah rekomendasi dikirim, jika iya update nilainya
        if ($request->has('rekomendasi')) {
            $validated['rekomendasi'] = $request->boolean('rekomendasi');
        }

        // Update image jika upload baru
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
            $validated['image'] = $imagePath;
        }

        $menu->update($validated);

        return response()->json(new MenusResource($menu), 200);
    }


    // menghapus menu tertentu
    public function destroy($id)
    {
        $menu = Menus::find($id);
        if ($menu) {
            $menu->delete();
            return response()->json(['message' => 'Menu deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Menu not found'], 404);
        }
    }






}
