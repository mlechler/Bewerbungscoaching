@extends('layouts.backend')

@section('title', $invoice->exists ? 'Editing Invoice No.'.$invoice->id : 'Create New Invoice')

@section('content')
    {{ Form::model($invoice, [
    'method' => $invoice->exists ? 'put' : 'post',
    'route' => $invoice->exists ? ['invoices.update', $invoice->id] : ['invoices.store'],
    'name' => 'invoiceForm'
    ]) }}

    @if ($invoice->exists)
        {{ Form::hidden('edit', $invoice) }}
    @endif
    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('member') }} <span class="required">*</span>
            {{ Form::select('member_id', $members, null, ['class' => 'form-control', 'id' => 'members', 'onchange' => 'getMemberData()']) }}
        </div>
    </div>
    {{ Form::label('type') }} <span class="required">*</span>
    <div class="form-group row">
        <div class="col-md-2">
            Individual Coaching
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','individualcoaching') }}
        </div>
        <div class="col-md-9">
            {{ Form::select('individualcoaching', ['' => ''], null, ['class' => 'form-control', 'id' => 'individualcoaching', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            Seminar
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','seminar') }}
        </div>
        <div class="col-md-9">
            {{ Form::select('seminar', ['' => ''], null, ['class' => 'form-control', 'id' => 'seminar', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            Application Package
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','package') }}
        </div>
        <div class="col-md-9">
            {{ Form::select('package', ['' => ''], null, ['class' => 'form-control', 'id' => 'package', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            Application Layout
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','layout') }}
        </div>
        <div class="col-md-9">
            {{ Form::select('layout', ['' => ''], null, ['class' => 'form-control', 'id' => 'layout', 'style' => 'visibility: hidden']) }}
        </div>
    </div>

    {{ Form::submit($invoice->exists ? 'Save Invoice' : 'Create New Invoice', ['class' => 'btn btn-success']) }}
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        $(document).ready(function() {
            if(document.getElementsByName('edit'))
            {
                getMemberData();
            }
        });

        var radio = document.invoiceForm.type;
        for (var i = 0; i < radio.length; i++) {
            radio[i].onclick = function () {
                var inputs = document.getElementsByTagName('select');
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].style.visibility = 'hidden'
                }
                document.getElementById(this.value).style.visibility = 'visible';
                document.getElementById('members').style.visibility = 'visible';
            };
        }
        function getMemberData() {
            var member = document.getElementById("members");
            var selectedMember = member.options[member.selectedIndex].value;
            $.ajax(
                {
                    type: 'GET',
                    url: '../../../backend/invoices/memberdata',
                    data: {
                        id: selectedMember
                    },
                    success: function (data) {
                        var coachings = $.map(data[0], function (value) {
                            return [value];
                        });
                        var coaching = document.getElementById('individualcoaching');
                        for (var i = 0; i < coachings.length; i++) {
                            var coachingOpt = document.createElement('option');
                            coachingOpt.innerHTML = coachings[i];
                            coachingOpt.value = coachings[i];
                            coaching.appendChild(coachingOpt);
                        }

                        var seminars = $.map(data[1], function (value) {
                            return [value];
                        });
                        var seminar = document.getElementById('seminar');
                        for (var j = 0; j < seminars.length; j++) {
                            var seminarOpt = document.createElement('option');
                            seminarOpt.innerHTML = seminars[j];
                            seminarOpt.value = seminars[j];
                            seminar.appendChild(seminarOpt);
                        }

                        var packages = $.map(data[2], function (value) {
                            return [value];
                        });
                        var application_package = document.getElementById('package');
                        for (var k = 0; k < packages.length; k++) {
                            var packageOpt = document.createElement('option');
                            packageOpt.innerHTML = packages[k];
                            packageOpt.value = packages[k];
                            application_package.appendChild(packageOpt);
                        }

                        var layouts = $.map(data[3], function (value) {
                            return [value];
                        });
                        var application_layout = document.getElementById('layout');
                        for (var l = 0; l < layouts.length; l++) {
                            var layoutOpt = document.createElement('option');
                            layoutOpt.innerHTML = layouts[l];
                            layoutOpt.value = layouts[l];
                            application_layout.appendChild(layoutOpt);
                        }
                    }
                });
        }
    </script>
@endsection