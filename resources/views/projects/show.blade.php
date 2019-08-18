@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500">
                <a href="/projects" class="text-gray-500">My Projects</a>  / {{ $project->title }}
            </p>

            <a href="{{ $project->path() . '/edit' }}" class="button">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-500 mb-3">Tasks</h2>

                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500' : '' }}">
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf

                            <input name="body" placeholder="Add a new task" class="w-full">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-gray-500 mb-3">General Notes</h2>

                    {{-- general notes --}}
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <textarea
                        name="notes"
                            class="card w-full mb-4"
                            style="min-height: 200px;"
                            placeholder="Anything special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>

                        <button class="button">Save</button>
                    </form>

                    @if ($errors->any())
                        <ul class="field mt-6 .list-none">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-700">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-10">
                @include('projects.card')
                @include('projects.activity.card')
            </div>
        </div>
    </main>

@endsection
