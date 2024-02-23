@extends('layouts.app')
@php
    //dump(old());
    // dump($cities);
    // dd($person_types);
@endphp
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container w-50">
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">Nowy uzytkownik</div>
            <form class="row g-3 p-4" novalidate action="{{ route('person.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <!-- X-XSRF-TOKEN -->
                <div class="col-md-4">
                    <label for="firstname" class="form-label">Imię</label>
                    <input type="text" class="form-control is-valid" id="firstname" name="firstname"
                        value="{{ old('firstname', '') }}">
                    <div class="invalid-feedback">
                        chujnia!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="lastname" class="form-label">Nazwisko</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                        value="{{ old('lastname', '') }}" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Nie prawidłowe nazwisko
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Data urodzenia</label>
                    <input type="text" class="datepicker form-control" id="born" name="born"
                        value="{{ old('born', '') }}" required>
                    <div class="invalid-feedback">
                        Nieprawidłowa data urodzenia
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Email</label>
                    <input type="text" class=" form-control" id="email" name="email" value="{{ old('email', '') }}"
                        required>

                    <div class="invalid-feedback">
                        Nieprawidłowa data urodzenia
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Telefon</label>
                    <input type="text" class=" form-control" id="phonenumber" name="phonenumber"
                        value="{{ old('phonenumber', '') }}" required>

                    <div class="invalid-feedback">
                        Nieprawidłowa telefon
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Płeć</label>
                    <select class="form-select" id="city_id" name="sex" required>
                        <option {{ old('sex') == 'male' ? 'selected' : '' }} value="male">
                            Facet
                        </option>
                        <option {{ old('sex') == 'famale' ? 'selected' : '' }} value="famale">
                            Laska
                        </option>
                    </select>
                    <div class="invalid-feedback">
                        Nieprawidłowa płeć
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="city_id" class="form-label">Miasto</label>
                    <select class="form-select" id="city_id" name="city_id" required>
                        <option selected value="">Wybierz...</option>
                        @foreach ($cities as $city)
                            <option {{ $city->id == old('city_id') ? 'selected' : '' }} value="{{ $city->id }}">
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Wybierz miasto
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="person_type_id" class="form-label">Typ usera</label>
                    <select class="form-select" id="person_type_id" name="person_type_id" required>
                        <option selected value="">Wybierz...</option>
                        @foreach ($person_types as $person_type)
                            <option {{ $person_type->id == old('person_type_id') ? 'selected' : '' }}
                                value="{{ $person_type->id }}">
                                {{ $person_type->type_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Wybierz typ uzytkownika
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end mt-4">
                    <button class="btn btn-primary" type="submit">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
@endsection
