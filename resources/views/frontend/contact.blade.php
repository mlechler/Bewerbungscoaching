{{ Form::open(['method' => 'post',
    'route' => 'frontend.contact.store']) }}

<div class="form-group">
    {{ Form::label('name') }}
    {{ Form::text('name', $loggedInUser ? $loggedInUser->firstname . ' ' . $loggedInUser->lastname : null, ['class' => 'form-control', $loggedInUser ? 'disabled' : null]) }}
</div>

<div class="form-group">
    {{ Form::label('email') }}
    {{ Form::text('email', $loggedInUser ? $loggedInUser->email : null, ['class' => 'form-control', $loggedInUser ? 'disabled' : null]) }}
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
