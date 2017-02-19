<style>
    table, th, td {
        border: 1px solid black;
    }
    table {
        width:50%;
    }
</style>

{{ $seminarappointment->seminar->title }}<br>
{{ $seminarappointment->formatDate() }}<br>
{{ $seminarappointment->formatTime() }}<br>
{{ $seminarappointment->employee->getName() }}<br><br>

<table class="table">
    <thead>
    <tr>
        <th>Participant</th>
        <th>Paid</th>
    </tr>
    </thead>
    <tbody>
    @foreach($seminarappointment->members as $member)
        <tr>
            <td>
                {{ $member->getName() }}
            </td>
            <td>
                {{ $member->pivot->paid ? 'Yes' : 'No' }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>