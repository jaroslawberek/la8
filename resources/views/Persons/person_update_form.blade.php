@extends('layouts.app')
@php
    // dump($form_fields);
    // dump(old());
@endphp
@section('content')
    @php
        // echo '<pre>';
        // if ($errors->get('firstname')) {
        //     echo $errors->get('firstname')[0];
        //     echo session('errors')->get('firstname')[0];
        //     // $object = new stdClass();
        //     // foreach ($errors->get('firstname') as $key => $value) {
        //     //     $object->error = $value;
        //     // }
        //     // echo $object->error;
        // }
    @endphp
    <div class="container w-50">
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">Edycja uzytkownika {{ $form_fields['firstname'] ?? '' }}
                @isinvalid('firstname')

            </div>
            <form class="row g-3 p-4"
                  novalidate
                  action="{{ route('person.update', $form_fields['id']) }}"
                  method="post">
                @csrf
                <!-- X-XSRF-TOKEN -->


                <div class="col-md-4">
                    <label for="firstname"
                           class="form-label">Imię</label>
                    <input type="text"
                           {{-- class="form-control @error('firstname') is-invalid @enderror" --}}
                           class="form-control @isinvalid('firstname')"
                           id="firstname"
                           name="firstname"
                           value="{{ old('firstname', $form_fields['firstname']) }}">
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
                           value="{{ old('lastname', $form_fields['lastname']) }}"
                           aria-describedby="inputGroupPrepend"
                           required>
                    @error('lastname')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Data urodzenia</label>
                    <input type="text"
                           class="datepicker form-control @error('born') is-invalid @enderror"
                           id="born"
                           name="born"
                           value="{{ old('born', $form_fields['born']) }}"
                           required>
                    @error('born')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Email</label>
                    <input type="text"
                           class=" form-control @error('firstname') is-invalid @enderror @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email', $form_fields['email']) }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Telefon</label>
                    <input type="text"
                           class=" form-control @error('phonenumber') is-invalid @enderror"
                           id="phonenumber"
                           name="phonenumber"
                           value="{{ old('phonenumber', $form_fields['phonenumber']) }}"
                           required>
                    @error('phonename')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="validationCustom02"
                           class="form-label">Płeć</label>
                    <select class="form-select @error('sex') is-invalid @enderror""
                            id="city_id"
                            name="sex"
                            required>
                        @if (isset($edycja))
                            <option {{ old('sex', $form_fields['sex']) == 'male' ? 'selected' : '' }}
                                    value="male">
                                Facet
                            </option>
                            <option {{ old('sex', $form_fields['sex']) == 'famale' ? 'selected' : '' }}
                                    value="famale">
                                Laska</option>
                        @else
                            <option value="male">Facet</option>
                            <option value="famale">Laska</option>
                        @endif

                    </select>
                    @error('sex')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-5">
                    <label for="city_id"
                           class="form-label">Miasto</label>
                    <select class="form-select @error('city_id') is-invalid @enderror""
                            id="city_id"
                            name="city_id"
                            required>
                        <option selected
                                value="">Wybierz...</option>
                        @foreach ($cities as $city)
                            @if (isset($edycja))
                                <option {{ $city->id == old('city_id', $form_fields['city_id']) ? 'selected' : '' }}
                                        value="{{ $city->id }}">
                                    {{ $city->city_name }}
                                </option>
                            @else
                                <option value="{{ $city->id }}"> {{ $city->city_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('city_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-5">
                    <label for="person_type_id"
                           class="form-label">Typ usera</label>
                    <select class="form-select @error('person_type_id') is-invalid @enderror""
                            id="person_type_id"
                            name="person_type_id"
                            required>
                        <option selected
                                value="">Wybierz...</option>
                        @foreach ($person_types as $person_type)
                            @if (isset($edycja))
                                <option {{ $person_type->id == old('person_type_id', $form_fields['person_type_id']) ? 'selected' : '' }}
                                        value="{{ $person_type->id }}">
                                    {{ $person_type->type_name }}
                                </option>
                            @else
                                <option value="{{ $person_type->id }}">{{ $person_type->type_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('person_type_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end mt-4">
                    <button class="btn btn-primary"
                            type="submit">Zapisz</button>
                </div>

            </form>
        </div>
    </div>
@endsection
