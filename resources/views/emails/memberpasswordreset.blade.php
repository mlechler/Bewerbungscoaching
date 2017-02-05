@extends('layouts.email')

@section('content')
    <tr>
        <td>
            Hi,

            <br><br>

            <div align="center">
                you are receiving this email because we received a password <br>
                reset request for your account.
                <br><br>
                Click on the button below to reset the password.
            </div>

            <br><br>

            <div align="center">
                <a href="{{ url('member/password/reset/'.$token) }}"
                   style=" line-height:40px; width:25%; display:inline-block; color: #fff; background-color: #337ab7; border-color: #2e6da4;"><span>Reset Password</span>
                </a>
            </div>

            <br><br>

            <div align="center">
                If you did not request a password reset and received this email incorrectly, <br>
                no further action is required.
            </div>
            <br><br>

            Best regards, <br>

            <div align="center"><strong>Marcel</strong> from ***</div>
        </td>
    </tr>
@endsection