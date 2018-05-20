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
    public function sortea() {
        $monto = 0;
        $random_number = intval("0" . rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));
        $newtree = substr($random_number, -3);

        $user = PaidChance::where('chances_id', null);
        if ($user->exists()) {

            foreach ($user->get() as $value) {
                $monto = $monto + $value->pago;
            }

            $chance = new Chances();
            $chance->juego = $random_number;
            $chance->monto = $monto;
            $chance->save();


            foreach ($user->get() as $dates) {
                $cha = PaidChance::find($dates->id);
                $cha->chances_id = $chance->id;
                $cha->save();
                if ($cha->juego == $random_number) {
                    $ganador = new PaidUser();
                    $ganador->users_id = $dates->users_id;
                    $ganador->chances_id = $chance->id;
                    $ganador->save();
                } else {
                    $tree = substr($cha->juego, -3);
                    if ($newtree == $tree) {
                        $ganador = new PaidUser();
                        $ganador->users_id = $dates->users_id;
                        $ganador->chances_id = $chance->id;
                        $ganador->save();
                    }
                }
            }
            return [
              "mesage" => "Sorteo finalizado",
              "code" => 200
            ];
        }
        return [
          "mesage" => "No hay usuarios nuevos para sortear",
          "code" => 500
        ];
    }

    public function ventasall() {
        $lastchans = Chances::orderBy('id', 'DESC')->first();
        $gandores = PaidUser::where('chances_id', $lastchans->id);
        $userarra = array();
        $code = 500;
        if ($gandores->exists()) {
            $code = 200;
            foreach ($gandores->get() as $value) {
                array_push($userarra, array(
                  "name" => $value->users->name,
                  "id" => $value->users->id,
                  "email" => $value->users->email,
                  "identity" => $value->users->identity
                ));
            }
        }
        return [
          "Ultimo" => $lastchans,
          "ganadores" => $userarra,
          "code" => $code
        ];
    }

}
