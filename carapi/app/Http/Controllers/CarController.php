<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *      title="API de Gestion des Voitures",
 *      version="1.0",
 *      description="Documentation de l'API pour la gestion des voitures en location"
 * )
 */
class CarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cars",
     *     summary="Récupérer la liste des voitures",
     *     tags={"Voitures"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des voitures avec pagination"
     *     )
     * )
     */
    public function index()
    {
        $cars = Car::paginate(10);
        return response()->json($cars);
    }

    /**
     * @OA\Post(
     *     path="/api/cars",
     *     summary="Ajouter une nouvelle voiture",
     *     tags={"Voitures"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"make","model","year","price_per_day"},
     *             @OA\Property(property="make", type="string", example="Toyota"),
     *             @OA\Property(property="model", type="string", example="Corolla"),
     *             @OA\Property(property="year", type="integer", example=2022),
     *             @OA\Property(property="price_per_day", type="number", format="float", example=35.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voiture ajoutée avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation échouée",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price_per_day' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/cars/{id}",
     *     summary="Récupérer les détails d'une voiture",
     *     tags={"Voitures"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la voiture",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la voiture"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvée"
     *     )
     * )
     */
    public function show(Car $car)
    {
        return response()->json($car);
    }

    /**
     * @OA\Put(
     *     path="/api/cars/{id}",
     *     summary="Mettre à jour une voiture",
     *     tags={"Voitures"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la voiture",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="make", type="string", example="Toyota"),
     *             @OA\Property(property="model", type="string", example="Corolla"),
     *             @OA\Property(property="year", type="integer", example=2022),
     *             @OA\Property(property="price_per_day", type="number", format="float", example=40.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voiture mise à jour avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation échouée",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Car $car)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'string|max:255',
            'model' => 'string|max:255',
            'year' => 'integer|min:1900|max:' . date('Y'),
            'price_per_day' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car->update($request->all());
        return response()->json($car, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/cars/{id}",
     *     summary="Supprimer une voiture",
     *     tags={"Voitures"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la voiture",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Voiture supprimée avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvée"
     *     )
     * )
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(null, 204);
    }
}
