<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrancesRequest;
use App\Http\Requests\UpdateBrancesRequest;
use App\Http\Resources\BrancesResource;
use App\Models\Branches;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    // Menampilkan semua cabang
    public function index()
    {
        return response()->json(BrancesResource::collection(Branches::all()), 200);
    }


    // Menampilkan cabang berdasarkan ID
    public function show($id)
    {
        $branch = Branches::find($id);

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        return response()->json(new BrancesResource($branch), 200);
    }


    //menambahkan cabang baru
    public function store(StoreBrancesRequest $request)
    {
        $validated = $request->validated();
        $branch = Branches::create($validated);

        return response()->json(new BrancesResource($branch), 201);


    }

    //mengupdate data cabang tertentu
    public function update(UpdateBrancesRequest $request, $id)
    {
        $branch = Branches::find($id);


        if ($branch) {
            $validated = $request->validated();
            $branch->update($validated);
            return response()->json(new BrancesResource($branch), 200);
        } else {
            return response()->json(['message' => 'Branch not found'], 404);
        }
    }

    //menghapus cabang tertentu
    public function destroy($id)
    {
        $branch = Branches::find($id);
        if ($branch) {
            $branch->delete();
            return response()->json(['message' => 'Branch deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Branch not found'], 404);
        }
    }
}
