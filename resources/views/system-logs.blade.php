<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Системный лог SBuilder</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @vite('resources/js/app.js')
</head>
<body>
<section class="container my-5">
    @if($logs->isNotEmpty())
        <div class="mb-5">
            <canvas id="testChart" data-json="{{ $chart }}"></canvas>
        </div>

        <ul class="list-group mb-5">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Кол-во записей в журнале
                <span class="badge bg-primary rounded-pill">{{ $logs->total() }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Кол-во записей за день
                <span class="badge bg-primary rounded-pill">{{ $logs_day_count }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Кол-во записей за час
                <span class="badge bg-primary rounded-pill">{{ $logs_hour_count }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Дата последней записи
                <span class="badge bg-primary rounded-pill">{{ $logs_latest_date }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Дата первой записи
                <span class="badge bg-primary rounded-pill">{{ $logs_oldest_date }}</span>
            </li>
        </ul>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" style="width: 5%">#</th>
                <th scope="col" style="width: 5%; text-align: center">Тип</th>
                <th scope="col">Дата и время</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->getAttribute('sl_id') }}</td>
                    <td style="text-align: center">{{ $log->getAttribute('sl_type') }}</td>
                    <td colspan="2">
                        {{ \Illuminate\Support\Carbon::parse($log->getAttribute('sl_date'))->diffForHumans() }}
                        <hr>
                        {{ \Illuminate\Support\Carbon::parse($log->getAttribute('sl_date'))->isoFormat('LLLL') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="word-wrap: anywhere;max-width: 70%">{!! $log->getAttribute('sl_message') !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex align-middle">
            {!! $logs->links() !!}
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            Записи в журнале отсутствуют
        </div>
    @endif
</section>
</body>
</html>
