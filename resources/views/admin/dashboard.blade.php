<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
            <a href="{{ url('admin/projects/create') }}"><button type="button" class="btn btn-success" style="margin-right: 10px;">
                        Create Project</button></a>
                    <a href="{{ url('admin/projects') }}">
                    <button type="button" class="btn btn-info">See Project</button>
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h4 class="p-6 font-semibold">Today's Time Logs</h4>
                <div class="container p-6">
                    <table class="table-auto w-full">
                        <thead class="bg-gray-700 text-white">
                        <tr>
                            <th scope="col" class="px-4 py-2">Id</th>
                            <th scope="col" class="px-4 py-2">Project Name</th>
                            <th scope="col" class="px-4 py-2">Assign</th>
                            <th scope="col" class="px-4 py-2">Date</th>
                            <th scope="col" class="px-4 py-2">TimeIn/TimeOut</th>
                            <th scope="col" class="px-4 py-2">Total Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($getTimeLog) > 0)
                            @foreach($getTimeLog as $k => $v)
                                <tr class="@if($loop->even) bg-gray-100 @endif">
                                    <th scope="row" class="border px-4 py-2">{{ $v->id }}</th>
                                    <td class="border px-4 py-2">{{ $v->project->title ?? "N/A" }}</td>
                                    <td class="border px-4 py-2">{{ $v->user->email ?? "N/A" }}</td>
                                    <td class="border px-4 py-2">{{ date('Y M,d', strtotime($v->date)) }}</td>
                                    <td class="border px-4 py-2">{{ $v->start_time }} / {{ $v->end_time }}</td>
                                    <td class="border px-4 py-2">{{ $v->between_hours }} Hours</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center">No time logs found for today.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
