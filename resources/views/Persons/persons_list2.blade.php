@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <a class="btn btn-primary" href="{{ route('person.create') }}">Nowy</a>
        <div class="card mt-3">
            <form id="people-list-form" action="#" method="get">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-search">
                        <input type="text" name="search" placeholder="szukaj" form="people-list-form"
                            value="{{ $filter['search'] ?? '5' }}">
                        <input type="submit" value="szukaj">
                    </div>
                    <div class="table-limit">
                        <input type="text" name="limit" value="{{ $filter['limit'] ?? ($people->limit ?? '') }}"
                            placeholder="ile wierszy" form="people-list-form">/{{ $people->total() ?? '0' }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table  table-striped table-bordered">
                            <thead">
                                <tr class="">
                                    <th>#</th>
                                    <th>Imię</th>
                                    <th>Nazwisko</th>
                                    <th>Funkcja</th>
                                    <th>Data ur.</th>
                                    <th>Płeć</th>
                                    <th>Miasto</th>
                                    <th> </th>
                                <tr class="">
                                    <th></th>
                                    <th><input type="text" name="firstname" form="people-list-form"
                                            value="{{ $filter['firstname'] ?? '' }}""></th>
                                    <th><input type="text" name="lastname" form="people-list-form"
                                            value="{{ $filter['lastname'] ?? '' }}""></th>
                                    <th><input type="text" name="type_name" form="people-list-form"
                                            value="{{ $filter['type_name'] ?? '' }}""></th>
                                    <th>
                                        <div class="input-group date">
                                            <input class="datepicker" autocomplete="off" type="text" name="born"
                                                value="{{ $filter['born'] ?? '' }}" form="people-list-form">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th><input type="text" name="sex" form="people-list-form"
                                            value="{{ $filter['sex'] ?? '' }}"></th>
                                    <th><input type="text" name="city_name" form="people-list-form"
                                            value="{{ $filter['city_name'] ?? '' }}"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse ($people as $person)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $person->firstname }}</td>
                                            <td>{{ $person->lastname }}</td>
                                            <td>{{ $person->type_name }}</td>
                                            <td>{{ $person->born }}</td>
                                            <td>{{ $person->sex }}</td>
                                            <td>{{ $person->city_name }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('person.edit', ['person_id' => $person->person_id]) }}">Edytuj</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <th class="align-middle">
                                        <td class="align-text-middle" colspan="7">Brak rekordów</td>
                                        </th>
                                    @endforelse
                                </tbody>
                        </table>
                    </div>
                    {{ $people->links() }}
                    {{-- {{ $people->links('pagination::bootstrap-4') }} --}}
                </div>
            </form>
        </div>



    </div>
@endsection
