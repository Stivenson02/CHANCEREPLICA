<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Chances;
use App\PaidChance;
use App\PaidUser;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($identity) {

        $user = User::where('identity', $identity);

        if ($user->exists()) {
            return [
              "code" => 200,
              "id" => $user->first()->id
            ];
        } else {
            return [
              "mesage" => "no existe",
              "code" => 500
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($requesr) {

        $dates = json_decode($requesr);
        $paid = new PaidChance();
        $paid->users_id = $dates->id;
        $paid->pago = $dates->pago;
        $paid->juego = $dates->numero;
        $paid->save();

        return [
          "code" => 200
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request) {
        $dates = json_decode($request);
        $user = new User();
        $user->email = $dates->email;
        $user->name = $dates->name;
        $user->identity = $dates->identity;
        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $userarra = array();
        $usuarios = User::all();
        foreach ($usuarios as $value) {
            array_push($userarra, array(
              "name" => $value->name,
              "id" => $value->id,
              "email" => $value->email,
              "identity" => $value->identity
            ));
        }

        return $userarra;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
