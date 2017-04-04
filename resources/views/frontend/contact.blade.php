{{ Form::open(['method' => 'post',
    'route' => 'frontend.contact.store']) }}

<div class="form-group">
    {{ Form::label('name') }} <span class="required">*</span>
    {{ Form::text('name', $loggedInUser ? $loggedInUser->firstname . ' ' . $loggedInUser->lastname : null, ['class' => 'form-control', $loggedInUser ? 'disabled' : null]) }}
</div>

<div class="form-group">
    {{ Form::label('email') }} <span class="required">*</span>
    {{ Form::text('email', $loggedInUser ? $loggedInUser->email : null, ['class' => 'form-control', $loggedInUser ? 'disabled' : null]) }}
</div>

<div class="form-group">
    {{ Form::label('contactperson') }} <span class="required">*</span>
    {{ Form::select('contactperson', $employees, null, ['class' => 'form-control', 'id' => 'contactperson']) }}
</div>

<div class="form-group">
    {{ Form::label('category') }} <span class="required">*</span>
    {{ Form::select('category', [
        '' => 'Select a category',
        'feedback' => 'Feedback',
        'product' => 'Question about a product',
        'booking' => 'Question about a booking',
        'invoice' => 'Question about an invoice',
        'discount' => 'Question about a discount',
    ], '', ['class' => 'form-control', 'id' => 'category']) }}
</div>

<div class="form-group">
    {{ Form::label('message') }} <span class="required">*</span>
    {{ Form::textarea('message', null, ['class' => 'form-control']) }}
</div>

{{ Form::submit('Contact Us', ['class' => 'btn btn-success']) }}
<a href="/" class="btn btn-danger">Cancel</a>
{{ Form::close() }}

<script>
    new SimpleMDE({
        toolbar: ["bold", "italic", "strikethrough", "heading", "|", "code", "quote", "unordered-list", "ordered-list",
            "clean-block", "|", "link", "image", "table", "horizontal-rule", "|", "preview", "side-by-side", "fullscreen", "|", "guide"]
    }).render();

    $('#category').on('change', function () {
        if ($(this).val() == 'booking' || $(this).val() == 'invoice' || $(this).val() == 'discount') {
            document.getElementById('contactperson').value = 0;
            $('#contactperson').prop('disabled',true);
        } else {
            $('#contactperson').prop('disabled',false);
        }
    });
</script>
