<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Nahid\JsonQ\Jsonq;
use GuzzleHttp\ClientInterface;

class TripController extends Controller
{
    public function index(Request $request){
        return view('home');
    }

    public function trip(Request $request){
        $trip = $this->readTrips()
            ->where('id','=',$request->id)
            ->get();

        $trip = array_values($trip)[0];

        return view('trip',compact('trip'));
    }

    public function trips(Request $request){
        $trips = $this->queryTrips($request);
        return view('trips',compact('trips'));
    }

    public function readTrips(){
        $url = 'https://hr.hava.bz/trips/recent.json';
        #$query = new Jsonq(public_path('trips.json'));
        $query = new Jsonq($url);



        return $query->from('trips');
    }

    public function queryTrips(Request $request){
        $trips = $this->readTrips();

        if (!isset($request->include_cancelled))
            $trips->where('status','=','COMPLETED');

        if (!empty($request->keyword)){
            $trips->whereContains('pickup_location',$request->keyword);
        }

        switch ($request->distance){
            case 'Under 3 km':
                $trips->where('distance','<',3);
                break;
            case '3 to 8 km':
                $trips->where('distance','>',3)
                    ->where('distance','<=',8);
                break;
            case '8 to 15 km':
                $trips->where('distance','>=',8)
                    ->where('distance','<=',15);
                break;
            case 'More than 15 km':
                $trips->where('distance','>',15);
                break;
        }

        switch ($request->time){
            case 'Under 5 min':
                $trips->where('duration','<',3);
                break;
            case '5 to 10 min':
                $trips->where('duration','>',5)
                    ->where('duration','<=',10);
                break;
            case '10 to 20 min':
                $trips->where('duration','>',10)
                    ->where('duration','<=',20);
                break;
            case 'More than 20 min':
                $trips->where('duration','>',20);
                break;
        }

        return $trips->get();
    }
}
