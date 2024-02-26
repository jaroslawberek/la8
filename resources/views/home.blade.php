@extends('layouts.app')

@section('content')
    <div class="container vh-100 flex-cs">

        <div class="card w-75 " style="height: 500px; box-sizing: border-box;">
            {{-- <div class="card w-75 mx-auto"> --}}
            <div class="card-body p-0 m-0" style="border: green solid; height: inherit; box-sizing: border-box;">
                <div class="card-header">Formularz</div>
                <form class="flex-ee" method="get" action="#" style="height: 460px;  ">

                    <div class="" style=" border: red solid; box-sizing: border-box;">
                        <label for="fff" class="form-label  mb-1">Name</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>
                    <div class="" style=" border: red solid; box-sizing: border-box;">
                        <label for="fff" class="form-label mb-1 ">Jarek</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>


                </form>
            </div>
        </div>

    </div>
@endsection
