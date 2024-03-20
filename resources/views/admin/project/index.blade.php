<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- Navigation Bar for Logout -->
                    <!-- Buttons for Time Filters and Projects -->
                    <div class="flex justify-between mb-4">
                        <div>
                            <button onclick="location.href='{{ route('projects.create') }}'" class="btn btn-info">
                                Create New Project
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container p-6">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Project Title</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($getProjects) > 0)
                                    @foreach($getProjects as $k => $v)
                                        <tr>
                                            <th scope="row">{{ $v->id }}</th>
                                            <td>{{ $v->title }}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('assign',['id'=>$v->id]) }}">Assign Project</a>
                                                <a class="btn btn-info" href="{{ route('assign',['id'=>$v->id]) }}">View Tme Logs</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
