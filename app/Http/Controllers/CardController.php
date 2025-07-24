<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        return Card::with('category')            // 👈 eager-load categoría
               ->where('user_id', $request->user()->id)
               ->latest()
               ->paginate(3);
    }

    /** Crear */
    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();

        if ($request->file('image')) {
            $data['image_path'] = $request->file('image')
                                          ->store('public/cards');
        }

        $card = $request->user()->cards()->create($data);

        return response()->json($card, 201);
    }

    /** Mostrar uno */
    public function show(Card $card)
    {
        $this->authorize('view', $card);     // opcional: policy
        return $card;
    }

    /** Actualizar */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $this->authorize('update', $card);

        $data = $request->validated();

        if ($request->file('image')) {
            // borra la anterior si existía
            if ($card->image_path) {
                Storage::delete($card->image_path);
            }
            $data['image_path'] = $request->file('image')
                                          ->store('public/cards');
        }

        $card->update($data);
        return $card;
    }

    /** Borrado lógico */
    public function destroy(Card $card)
    {
        $this->authorize('delete', $card);
        $card->delete();
        return response()->noContent();
    }
}
