@extends('layouts.app')

@section('title') Search @endsection

@section('content')
    <form method="GET" action="{{route('trips')}}">
        @csrf
        Keyword
        <input class="form-control" name="keyword">

        <br/>
        <div class="form-check">
            <input name="include_cancelled" class="form-check-input" type="checkbox" value="1" id="cancelledCheck1">
            <label class="form-check-label" for="defaultCheck1">
                Include canceled trips
            </label>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-6">
                <p>Distance</p>

                @foreach(config('tripsearch.distance') as $key=>$value)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distance" id="distanceRadios{{$key}}" value="{{$value}}" {{$key == 0?'checked':''}}>
                        <label class="form-check-label" for="distanceRadios{{$key}}">
                            {{$value}}
                        </label>
                    </div>
                @endforeach

            </div>

            <div class="col-md-6">
                <p>Time</p>
                @foreach(config('tripsearch.time') as $key=>$value)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="time" id="timeRadios{{$key}}" value="{{$value}}" {{$key == 0?'checked':''}}>
                        <label class="form-check-label" for="timeRadios{{$key}}">
                            {{$value}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <hr/>
        <div class="text-center">
            <button type="submit" class="btn btn-outline-secondary">SEARCH</button>
        </div>
    </form>
@stop
