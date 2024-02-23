@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Title</h5>
                <form class="row g-3 p-4" method="get" action="#">
                    <div class="col-md-4">
                        <label for="fff" class="form-label  mb-1">Name</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>
                    <div class="col-md-4">
                        <label for="fff" class="form-label mb-1 ">Jarek</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>
                    <div class="col-md-4">
                        <label for="fff" class="form-label mb-1">Name</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>
                    <div class="col-md-8">
                        <label for="fff" class="form-label mb-1">Name</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>
                    <div class="col-md-4">
                        <label for="fff" class="form-label mb-1">Name</label>
                        <input type="text" name="fff" id="fff" class="form-control" placeholder="oooo"
                            aria-describedby="helpId" />
                        <small id="helpId" class="text-muted">Help text</small>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
