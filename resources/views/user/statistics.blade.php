<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Navigation Bar for Logout -->
                    <!-- Buttons for Time Filters and Projects -->
                    <div class="row">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="btn btn-info">Project Name:</span>
{{--                                {{ var_export($projectData['id']) }}--}}
                                <span class="btn btn-primary">{{ $projectData['title'] ?? null }}</span>
                            </div>
                        </div>

                        <div class="container p-6">
                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total Hours worked</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dailyHours as $day)
                                        <tr>
                                            <th scope="row">{{ date('Y M,D',strtotime($day->date)) }}</th>
                                            <td>{{ round($day->total_hours,2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total Weekly Hours</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($weeklyHours as $weekly)
                                        <tr>
                                            <td>{{ $weekly->week }}</td>
                                            <td>{{ $weekly->total_hours }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total Weekly Hours</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($monthlyHours as $monthly)
                                        <tr>
                                            <td>{{ $monthly->year }}--{{ $monthly->month }} </td>
                                            <td>{{ $monthly->total_hours }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
