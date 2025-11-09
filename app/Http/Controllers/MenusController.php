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

    // menambahkan menu baru
    public function store(StoreMenusRequest $request)
    {
        $validated = $request->validated();

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
        if ($menu) {
            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('menus', 'public');
                $validated['image'] = $imagePath;
            }

            $menu->update($validated);
            return response()->json(new MenusResource($menu), 200);
        } else {
            return response()->json(['message' => 'Menu not found'], 404);
        }
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
