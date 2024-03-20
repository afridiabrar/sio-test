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
                    {{ __("You're logged in!") }}
                    <!-- Navigation Bar for Logout -->
                    <!-- Buttons for Time Filters and Projects -->
                    <div class="flex justify-between mb-4">
                        <div>
                            <button onclick="location.href='{{ route('statistics',['id'=>$project_id]) }}'" class="btn btn-info">
                                View All Statistics
                            </button>
                        </div>
                    </div>
                    <!-- Start/End Buttons -->
                    <div class="flex justify-start mb-4">
                        <form method="post" action="{{ route('time-logs.store') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" value="{{ $project_id }}" name="project_id">
                            <input type="submit" value="start" name="action" class="btn btn-success">
                            <input type="submit" value="end" name="action" class="btn btn-danger">
                        </form>
                    </div>
                    <div class="row">
                        <div class="container p-6">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">TimeIn/TimeOut</th>
                                    <th scope="col">Total Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($getTimeLog) > 0)
                                    @foreach($getTimeLog as $k => $v)
                                        <tr>
                                            <th scope="row">{{ $v->id }}</th>
                                            <td>{{ date('Y M,D',strtotime($v->date)) }}</td>
                                            <td>{{ $v->start_time }}/{{ $v->end_time }}</td>
                                            <td>{{ $v->between_hours }} Hours</td>
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
