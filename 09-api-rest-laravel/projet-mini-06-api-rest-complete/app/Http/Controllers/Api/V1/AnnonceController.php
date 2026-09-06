<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;
use App\Http\Resources\V1\AnnonceResource;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnonceController extends Controller
{
    private const COLONNES_TRI_AUTORISEES = ['prix', 'created_at'];

    /**
     * @OA\Get(
     *     path="/api/v1/annonces",
     *     summary="Lister les annonces actives",
     *     @OA\Parameter(name="recherche", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="categorie", in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Liste paginée des annonces")
     * )
     */
    public function index(Request $request)
    {
        $tri = in_array($request->input('tri'), self::COLONNES_TRI_AUTORISEES, true)
            ? $request->input('tri')
            : 'created_at';
        $ordre = $request->input('ordre') === 'asc' ? 'asc' : 'desc';

        $annonces = Annonce::query()
            ->with(['categorie', 'user'])
            ->actives()
            ->when($request->filled('recherche'), fn ($q) => $q->where('titre', 'like', '%' . $request->input('recherche') . '%'))
            ->when($request->filled('categorie'), fn ($q) => $q->deLaCategorie((int) $request->input('categorie')))
            ->orderBy($tri, $ordre)
            ->paginate($request->integer('par_page', 15));

        return AnnonceResource::collection($annonces);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/annonces/{id}",
     *     summary="Afficher une annonce",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Annonce trouvée"),
     *     @OA\Response(response=404, description="Annonce non trouvée")
     * )
     */
    public function show(Annonce $annonce)
    {
        return new AnnonceResource($annonce->load(['categorie', 'user']));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/annonces",
     *     summary="Créer une annonce",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=201, description="Annonce créée"),
     *     @OA\Response(response=401, description="Authentification requise"),
     *     @OA\Response(response=422, description="Erreur de validation")
     * )
     */
    public function store(StoreAnnonceRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $annonce = Annonce::create($data);

        return (new AnnonceResource($annonce))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateAnnonceRequest $request, Annonce $annonce)
    {
        $annonce->update($request->validated());

        return new AnnonceResource($annonce->fresh(['categorie', 'user']));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/annonces/{id}",
     *     summary="Supprimer une annonce",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=204, description="Annonce supprimée"),
     *     @OA\Response(response=403, description="Non autorisé")
     * )
     */
    public function destroy(Request $request, Annonce $annonce)
    {
        $this->authorize('delete', $annonce);

        $annonce->delete();

        return response()->noContent();
    }
}
