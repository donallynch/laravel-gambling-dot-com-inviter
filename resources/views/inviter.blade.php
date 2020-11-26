@extends('app')

@section('content')
    <div class="row" id="gui">
        <div class="col-12">
            <div class="page-title">
                <h1>{!! __('messages.inviter') !!}</h1>
                <h3>
                    {!! __('messages.inviter-desc', ['threshold' => $threshold]) !!}
                </h3>
                <ul>
                    @foreach ($data as $key => $value)
                        <li>{{ $value['name'] }}, {!! __('messages.affiliate-id', ['id' => $value['affiliate_id']]) !!}</li>
                    @endforeach
                </ul>

                <ul>
                    @if(empty($data))
                        <li>{!! __('messages.empty-list') !!}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent()
@endsection
