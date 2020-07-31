@extends('layouts.app')

@section('title') Details @endsection

@section('styles')
    <style>
        .card{
            border-radius: 0 !important;
        }

        .costing,.driver_rating{
            float: right;
        }

        .back{
            color: #1b1e21;
        }

        .pickup-icon{
            color: green;
            background-color: green;
            border-radius: 50%;
            width: 15px;
            height: 15px;
        }

        .dropoff-icon{
            color: red;
            border-radius: 50%;
            width: 15px;
            height: 15px;
        }

        .tripcard{
            cursor: pointer;
            border: none !important;
        }

        table{
            width: 100%;
        }
    </style>

    <link href="{{asset('assets/css/trip.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
@endsection

@section('header_scripts')
    <script>var apikey = 'Rvf23FN7IU3QCrR8fJLSo9z7Xj_F4Z2APbzIJQkvt1k';</script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endsection

@section('content')

    <p style="margin-bottom: 20px;margin-top: 20px">
        <a class="back" href="{{\Illuminate\Support\Facades\URL::previous()}}"><i data-feather="chevron-left"></i></a> Trip Details
    </p>

    <div class="card tripcard">
        <div class="card-body">
            <p class="card-title text-muted">
                <b>{{$trip['request_date']}}</b>
                <span class="costing"><i class="fa fa-money"></i> {{$trip['cost']}} {{$trip['cost_unit']}}</span>
            </p>

            <hr/>

            <p class="card-text"><i class="pickup-icon" data-feather="circle"></i> {{$trip['pickup_location']}} <span style="float: right">{{date('h:i A', strtotime($trip['pickup_date']))}}</span></p>

            <p class="card-text"><i class="dropoff-icon" data-feather="circle"></i> {{$trip['dropoff_location']}} <span style="float: right">{{date('h:i A', strtotime($trip['dropoff_date']))}}</span></p>
            <hr/>

            <table>
                <tr>
                    <td>
                        <img width="100" src="https://hr.hava.bz/trips/c9.jpg"><br/>
                        {{$trip['car_make']}} {{$trip['car_model']}}
                    </td>
                    <td>
                        Distance <span style="float: right">{{$trip['distance']}}{{$trip['distance_unit']}}</span><br/>
                        Duration <span style="float: right">{{$trip['duration']}}{{$trip['duration_unit']}}</span><br/>
                        Sub total <span style="float: right">{{$trip['cost']}}{{$trip['cost_unit']}}</span><br/>
                    </td>

                    <td class="text-right">
                        <?php $rating = $trip['driver_rating']; ?>
                        @if($rating > 3)
                            <img width="70" style="margin-left: auto;margin-right: 18%" src="{{asset('assets/img/happy.png')}}">
                        @elseif($rating = 3 || $rating = 0)
                            <img width="70" style="margin-left: auto;margin-right: 18%" src="{{asset('assets/img/meh.png')}}">
                        @else
                            <img width="70" style="margin-left: auto;margin-right: 18%" src="{{asset('assets/img/sad.png')}}">
                        @endif
                        <br/>
                        <p style="margin-left: auto;" id="driver_rating" class="{{$trip['driver_rating']}}"></p>
                    </td>
                </tr>
            </table>

            <hr/>

            <div id="markers-on-the-map">
                <div id="map"></div>
                <div id="panel"></div>
            </div>
        </div>
        @endsection

        @section('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

            <script>
                feather.replace();

                function calculateRouteFromAtoB (platform) {
                    const params = {
                        mode: 'fastest;car',
                        representation: 'display',
                        routeattributes : 'waypoints,summary,shape,legs',
                        maneuverattributes: 'direction,action',
                        waypoint0: "{{$trip['pickup_lat']}},{{$trip['pickup_lng']}}",
                        waypoint1: '{{$trip['dropoff_lat']}},{{$trip['dropoff_lng']}}',
                    };

                    var router = platform.getRoutingService(), routeRequestParams = params;

                    router.calculateRoute(
                        routeRequestParams,
                        onSuccess,
                        onError
                    );
                }

                $(function () {
                    $("#driver_rating").rateYo({
                        rating: {{$trip['driver_rating']}}
                    });
                });
            </script>
            <script type="text/javascript" src='{{asset('assets/js/trip.js')}}'></script>
@endsection
