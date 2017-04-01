@extends('layouts.backend')

@section('title', $invoice->exists ? 'Editing Invoice No.'.$invoice->id : 'Create New Invoice')

@section('content')
    {{ Form::model($invoice, [
    'method' => $invoice->exists ? 'put' : 'post',
    'route' => $invoice->exists ? ['invoices.update', $invoice->id] : ['invoices.store'],
    'name' => 'invoiceForm'
    ]) }}

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
            {{ Form::radio('type','individualcoaching', $invoice->individualcoaching_id ? 'checked' : null) }}
        </div>
        <div class="col-md-9">
            {{ Form::select('individualcoaching', $invoice->exists ? $coachings : ['' => ''], $invoice->exists ? $invoice->individualcoaching_id : null, ['class' => 'form-control', 'id' => 'individualcoaching', 'style' => $invoice->individualcoaching_id ? 'visibility: visible' : 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            Seminar
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','seminar', $invoice->booking_id ? 'checked' : null) }}
        </div>
        <div class="col-md-9">
            {{ Form::select('seminar', $invoice->exists ? $bookings : ['' => ''], $invoice->exists ? $invoice->booking_id : null, ['class' => 'form-control', 'id' => 'seminar', 'style' => $invoice->booking_id ? 'visibility: visible' : 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            Application Package
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','package', $invoice->packagepurchase_id ? 'checked' : null) }}
        </div>
        <div class="col-md-9">
            {{ Form::select('package', $invoice->exists ? $packagepurchases : ['' => ''], $invoice->exists ? $invoice->packagepurchase_id : null, ['class' => 'form-control', 'id' => 'package', 'style' => $invoice->packagepurchase_id ? 'visibility: visible' : 'visibility: hidden']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            Application Layout
        </div>
        <div class="col-md-1">
            {{ Form::radio('type','layout', $invoice->layoutpurchase_id ? 'checked' : null) }}
        </div>
        <div class="col-md-9">
            {{ Form::select('layout', $invoice->exists ? $layoutpurchases : ['' => ''], $invoice->exists ? $invoice->layoutpurchase_id : null, ['class' => 'form-control', 'id' => 'layout', 'style' => $invoice->layoutpurchase_id ? 'visibility: visible' : 'visibility: hidden']) }}
        </div>
    </div>

    {{ Form::submit($invoice->exists ? 'Save Invoice' : 'Create New Invoice', ['class' => 'btn btn-success']) }}
    <a href="{{ route('invoices.index') }}" class="btn btn-danger">Cancel</a>
    {{ Form::close() }}

    <script>
        var radio = document.invoiceForm.type;
        for (var i = 0; i < radio.length; i++) {
            radio[i].onclick = function () {
                var selects = document.getElementsByTagName('select');
                for (var i = 0; i < selects.length; i++) {
                    selects[i].style.visibility = 'hidden'
                }
                document.getElementById(this.value).style.visibility = 'visible';
                document.getElementById('members').style.visibility = 'visible';
            };
        }
        function getMemberData() {
            var member = document.getElementById("members");
            var selectedMember = member.options[member.selectedIndex].value;

            var selects = document.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                selects[i].style.visibility = 'hidden';
            }
            document.getElementById('members').style.visibility = 'visible';

            var radios = document.getElementsByName('type');
            for (var j = 0; j < radios.length; j++) {
                radios[j].checked = false;
            }

            document.getElementById('individualcoaching').options.length = 1;
            document.getElementById('seminar').options.length = 1;
            document.getElementById('package').options.length = 1;
            document.getElementById('layout').options.length = 1;

            $.ajax(
                {
                    type: 'GET',
                    url: '../../../backend/invoices/memberdata',
                    data: {
                        id: selectedMember
                    },
                    success: function (data) {
                        coachings = $.map(data[0], function (value) {
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