@extends('layouts.app')

@section('title', 'Projects List')


@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome Progetto</th>
                <th scope="col">Linguaggi utilizzati</th>
                <th scope="col">Data inizio progetto</th>
                <th scope="col">Data fine progetto</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->programming_languages }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>
                        <a href={{ route('admin.projects.show', $project) }}>
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $projects->links('pagination::bootstrap-5') }}
@endsection
