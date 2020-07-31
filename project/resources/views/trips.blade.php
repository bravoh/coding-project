@extends('layouts.app')

@section('title') Search Results @endsection

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
        }
    </style>
@endsection

@section('content')

    <p style="margin-bottom: 20px;margin-top: 20px">
        <a class="back" href="{{route('index')}}"><i data-feather="chevron-left"></i></a>Trips({{count($trips)}})
    </p>
    @foreach($trips as $key=>$value)
            <div class="card tripcard" data-link="" onclick='location.href="{{route('trip',$value['id'])}}"'>
                <div class="card-body">
                    <p class="card-title text-muted">
                        <b>{{$value['pickup_date']}}</b>
                        <span class="costing">
                        {{$value['cost']}}{{$value['cost_unit']}}
                    </span>
                    </p>

                    <p class="card-text">
                        <i class="pickup-icon" data-feather="circle"></i> {{$value['pickup_location']}}
                        <span class="driver_rating">
                            <?php $rating = $value['driver_rating'] ?>
                                @for($i=1; $i < 6;$i++)
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            @if(!($rating >= $i && $rating != 0))
                                               fill="none"
                                            @endif
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-star"
                                            style="color: black">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">

                                        </polygon>
                                    </svg>
                                @endfor
                        </span>
                    </p>

                    <p class="card-text">
                        <i class="dropoff-icon" data-feather="circle"></i>
                        {{$value['dropoff_location']}}
                    </p>
                    <p class="card-text text-right text-muted">
                        {{$value['status']}}
                        <i style="color: {{$value['status'] == 'COMPLETED'?'green':'red'}}" data-feather="{{$value['status'] == 'COMPLETED'?'check':'alert-circle'}}"></i>
                    </p>
                </div>
            </div>
    @endforeach
@stop

@section('scripts')
    <script>
        feather.replace()
    </script>
@endsection
