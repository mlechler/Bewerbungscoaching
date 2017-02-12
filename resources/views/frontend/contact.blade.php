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
    {{ Form::label('category') }}
    {{ Form::select('category', [
        '' => 'Select a category',
        'feedback' => 'Feedback',
        'product' => 'Question about a product',
        'booking' => 'Question about a booking',
        'invoice' => 'Question about an invoice',
        'discount' => 'Question about a discount',
    ], '', ['class' => 'form-control']) }}
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
