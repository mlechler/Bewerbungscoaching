{{ Form::open() }}

<div class="form-group">
    {{ Form::label('name') }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('email') }}
    {{ Form::text('email', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('message') }}
    {{ Form::textarea('message', null, ['class' => 'form-control']) }}
</div>

{{ Form::submit('Contact Us', ['class' => 'btn btn-success']) }}
<a href="/" class="btn btn-danger">Cancel</a>
{{ Form::close() }}

<script>
    new SimpleMDE().render();
</script>
