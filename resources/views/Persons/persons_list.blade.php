@extends('layouts.forntend')

@section('content')
    <div id="wrapper"></div>
    <script>
        const grid = new gridjs.Grid({
            columns: [{
                    name: "Imie",
                    id: 'firstname',
                },
                'Nazwisko',
                'Telefon',
                'Data ur.',
                'Płeć',
                'city',
            ],
            search: {
                server: {
                    url: (prev, keyword) => `${prev}&search=${keyword}`
                }
            },
            pagination: {
                limit: 5,
                summary: true,
                server: {
                    url: (prev, page, limit) => {
                        console.log(prev);
                        console.log(page);
                        console.log(limit);
                        return `${prev}&limit=${limit}&offset=${page  * limit}`
                    }
                }
            },
            sort: {
                multicolumn: false,
                server: {
                    url: (prev, columns) => {
                        if (!columns.length) return prev;
                        //  console.log(`prev:${prev}`);
                        console.log(JSON.stringify(columns));
                        const col = columns[0]; //[{"index":0,"direction":1}] gdy kliknieta pierwsza kolumna
                        const dir = col.direction === 1 ? 'asc' : 'desc';
                        //  console.log(JSON.stringify(col)); //{"index":0,"direction":1}
                        let colName = ['firstname', 'lastname', 'phonenumber', 'born', 'sex'][col.index];

                        return `${prev}&order=${colName}&dir=${dir}`;
                    }
                }
            },
            server: {
                url: "{{ route('get.ajax_get_persons_list') }}" + "?1=1",
                then: (data) => {
                    console.log(data.total);
                    return data.result.map((x) => [x.firstname, x.lastname, x.phonenumber, x.born, x.sex, x
                        .city])
                },
                total: data => data.total
            },

        }).render(document.getElementById("wrapper"));
        console.log(grid.config.server.total);
    </script>
@endsection
