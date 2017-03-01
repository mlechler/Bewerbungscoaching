@extends('layouts.frontend')

@section('title', 'Application Layouts')

@section('content')
    <div id="layouts">
        @foreach($applicationlayouts as $layout)
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title row">
                            <a data-toggle="collapse"
                               href="#collapse{{ $layout->id }}">
                                <div class="col-md-6">{{ $layout->title }}</div>
                                <div class="col-md-3">test</div>
                                <div class="col-md-3" align="right">test2</div>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{{ $layout->id }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <strong>Description</strong><br>
                            {!! $layout->descriptionHtml() !!}
                            <strong>Preview</strong><br>
                            {{ $layout->preview }}<br><br>
                            <strong>Price</strong><br>
                            {{ $layout->price }} €<br><br>
                            @if($loggedInUser)
                                <button class="btn btn-success" data-toggle="modal"
                                        data-target="#modal{{ $layout->id }}">Purchase
                                </button>
                            @else
                                <button class="btn btn-success" disabled>Purchase</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal{{ $layout->id }}" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <p class="modal-title">Your Purchase</p>
                        </div>
                        {{ Form::open([
                        'method' =>'post',
                        'route' => ['frontend.applicationlayouts.purchase', $layout->id]
                        ]) }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Payment Method</strong>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('PayPal') }}
                                        {{ Form::radio('type','paypal') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('transfer') }}
                                        {{ Form::radio('type','transfer') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-4">
                                    {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Discount']) }}</td>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Check your Article</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>{{ $layout->title }}</strong>
                                </div>
                                <div class="col-md-4">
                                    <div align="right"><strong>{{ $layout->price }} €</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            {{ Form::submit('Purchase', ['class' => 'btn btn-success']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        var $layouts = $('#layouts');
        $layouts.on('show.bs.collapse', '.collapse', function () {
            $layouts.find('.collapse.in').collapse('hide');
        });
    </script>
@endsection