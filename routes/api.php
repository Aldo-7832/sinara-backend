<?php
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonacionController;
use App\Http\Controllers\RecolectadoController;
use App\Http\Controllers\CadenaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\ObservacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Open requests
//Auth
Route::post('/login',[AuthController::class, 'login']);//login to get token

//Send token to this requests
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('auth', AuthController::class);
    Route::post('/auth/register',[AuthController::class, 'register']); //Register only user
    //Donations
    Route::resource('donations',DonacionController::class);
    Route::get('/donations/donationsByIdUser/{idUser}',[DonacionController::class, 'donationsByIdUser']);
    Route::get('/donations/show',[DonacionController::class, 'show']);
    Route::put('/donations/update/{id}',[DonacionController::class, 'update']);
    Route::put('/donations/updateStatus/{id}',[DonacionController::class, 'updateStatus']);
    Route::post('/donations/create',[DonacionController::class, 'create']);
    Route::delete('/donations/destroy/{id}',[DonacionController::class, 'destroy']);
    //Picking
    Route::resource('picking', RecolectadoController::class);
    Route::get('/picking/getProductsByIdDonation/{idDonation}/{idUser}',[RecolectadoController::class, 'getProductsByIdDonation']);
    Route::get('/picking/donationsByCollectedDate/{fecha_inicial}/{fecha_final}',[RecolectadoController::class, 'donationsByCollectedDate']);
    Route::get('/picking/getProductsOnlyByIdDonation/{idDonation}',[RecolectadoController::class, 'getProductsOnlyByIdDonation']);
    Route::get('/picking/getFilterProductsByIdDonation/{idDonation}/{idUser}/{product}',[RecolectadoController::class, 'getFilterProductsByIdDonation']);
    Route::put('/picking/update/{id}',[RecolectadoController::class, 'update']);
    Route::put('/picking/updateStatus/{id}',[RecolectadoController::class, 'updateStatus']);
    Route::post('/picking/create',[RecolectadoController::class, 'create']);
    Route::delete('/picking/destroy/{id}',[RecolectadoController::class, 'destroy']);
    //Store
    Route::resource('store', CadenaController::class);
    Route::get('/store/show',[CadenaController::class, 'show']);
    Route::get('/store/getOnlyActive/{estatus}',[CadenaController::class, 'getOnlyActive']);
    Route::post('/store/validAddCadena',[CadenaController::class, 'validAddCadena']);
    Route::get('/store/getCadenas',[CadenaController::class, 'getCadenas']);
    Route::get('/store/getCadenasByFilter/{cadena}',[CadenaController::class, 'getCadenasByFilter']);
    Route::put('/store/update/{id}',[CadenaController::class, 'update']);
    Route::post('/store/create',[CadenaController::class, 'create']);
    Route::delete('/store/destroy/{id}',[CadenaController::class, 'destroy']);
    //Category
    Route::resource('category', CategoriaController::class);
    Route::get('/category/show',[CategoriaController::class, 'show']);
    Route::put('/category/update/{id}',[CategoriaController::class, 'update']);
    Route::post('/category/create',[CategoriaController::class, 'create']);
    Route::delete('/category/destroy/{id}',[CategoriaController::class, 'destroy']);
    //Person
    Route::resource('person', PersonaController::class);
    Route::post('/person/validUpdateUser',[PersonaController::class, 'validUpdateUser']);
    Route::post('/person/validNewUser',[PersonaController::class, 'validNewUser']);
    Route::get('/person/show',[PersonaController::class, 'show']);
    Route::put('/person/update/{id}',[PersonaController::class, 'update']);
    Route::post('/person/create',[PersonaController::class, 'create']);
    Route::delete('/person/destroy/{id}',[PersonaController::class, 'destroy']);
    //Product
    Route::resource('product', ProductoController::class);
    Route::get('/product/show',[ProductoController::class, 'show']);
    Route::get('/product/getProductsByFilter/{productToFind}',[ProductoController::class, 'getProductsByFilter']);
    Route::put('/product/update/{id}',[ProductoController::class, 'update']);
    Route::post('/product/create',[ProductoController::class, 'create']);
    Route::delete('/product/destroy/{id}',[ProductoController::class, 'destroy']);
    //Ubication
    Route::resource('ubication', UbicacionController::class);
    Route::get('/ubication/show',[UbicacionController::class, 'show']);
    Route::put('/ubication/update/{id}',[UbicacionController::class, 'update']);
    Route::post('/ubication/create',[UbicacionController::class, 'create']);
    Route::delete('/ubication/destroy/{id}',[UbicacionController::class, 'destroy']);
    //Users
    Route::put('/users/update/{id}',[UsuarioController::class, 'update']);
    Route::put('/users/updateStatus/{id}',[UsuarioController::class, 'updateStatus']);
    Route::get('/users/getRecolectores',[UsuarioController::class, 'getRecolectores']);
    Route::get('/users/getRecolectorByEstatus/{estatus}',[UsuarioController::class, 'getRecolectorByEstatus']);
    //Observation
    Route::post('/observation/create',[ObservacionController::class, 'create']);
    Route::get('/observation/getObservationByIdRecolectado/{idRecolectado}',[ObservacionController::class, 'getObservationByIdRecolectado']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


