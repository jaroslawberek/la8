@extends('layouts.app')
@php
    //dump(old());
    // dump($cities);
    // dd($person_types);
@endphp
@section('content')
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <div class="container w-50">
        <div class="card mt-3">

            <div class="card-header d-flex justify-content-between">Nowy uzytkownik</div>

            <form class="row g-3 p-4"
                  novalidate
                  action="{{ route('person.store') }}"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <!-- X-XSRF-TOKEN -->

                <div class="col-md-4">
                    <label for="firstname"
                           class="form-label">Imię</label>
                    <input type="text"
                           class="form-control @error('firstname') is-invalid @enderror"
                           id="firstname"
                           name="firstname"
                           value="{{ old('firstname', '') }}">
                    @error('firstname')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="lastname"
                           class="form-label">Nazwisko</label>
                    <input type="text"
                           class="form-control @error('lastname') is-invalid @enderror"
                           id="lastname"
                           name="lastname"
                           value="{{ old('lastname', '') }}"
                           aria-describedby="inputGroupPrepend"
                           required>
                    @error('lastname')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Data
                        urodzenia</label>
                    <input type="text"
                           class="datepicker form-control @error('born') is-invalid @enderror"
                           id="born"
                           name="born"
                           value="{{ old('born', '') }}"
                           required>
                    @error('born')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Email</label>
                    <input type="text"
                           class="form-control @error('email') is-invalid @enderror""
                           id="email"
                           name="email"
                           value="{{ old('email', '') }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Telefon</label>
                    <input type="text"
                           class="form-control @error('phonenumber') is-invalid @enderror"
                           id="phonenumber"
                           name="phonenumber"
                           value="{{ old('phonenumber', '') }}"
                           required>

                    @error('phonenumber')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Płeć</label>
                    <select class="form-select @error('sex') is-invalid @enderror"
                            id="city_id"
                            name="sex"
                            required>
                        <option {{ old('sex') == 'male' ? 'selected' : '' }}
                                value="male">
                            Facet
                        </option>
                        <option {{ old('sex') == 'famale' ? 'selected' : '' }}
                                value="famale">
                            Laska
                        </option>
                    </select>
                    @error('sex')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-5">
                    <label for="city_id"
                           class="form-label">Miasto</label>
                    <select class="form-select @error('city_id') is-invalid @enderror"
                            id="city_id"
                            name="city_id"
                            required>
                        <option selected
                                value="">Wybierz...</option>
                        @foreach ($cities as $city)
                            <option {{ $city->id == old('city_id') ? 'selected' : '' }}
                                    value="{{ $city->id }}">
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-5">
                    <label for="city_id"
                           class="form-label">Typ usera</label>
                    <select class="form-select @error('person_type_id') is-invalid @enderror"
                            id="person_type_id"
                            name="person_type_id"
                            required>
                        <option selected
                                value="">Wybierz...</option>
                        @foreach ($person_types as $person_type)
                            <option {{ $person_type->id == old('') ? 'selected' : '' }}
                                    value="{{ $person_type->id }}">
                                {{ $person_type->type_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('person_type_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
        </div>


        <div class="col-12 d-flex justify-content-end mt-4">
            <button class="btn btn-primary"
                    type="submit">Zapisz</button>
        </div>


        </form>
    </div>
    </div>
@endsection
