@if ($passed)
    <div class="w-full h-full flex flex-col justify-evenly items-center">
        <h1 class='text-xl text-violet-600 dark:text-tomato'>Congratulation!</h1>
        <p>Tests Runs: {{$testsCompleted}}</p>
        <p>{{$asserts}}</p>
    </div>

@else
    @foreach ($errorLines as $line)
        <p class="py-2 text-sm">{!!$line!!}</p>
    @endforeach
@endif
