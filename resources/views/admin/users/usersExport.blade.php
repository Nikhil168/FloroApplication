<!doctype html>
<html>
<head>
    <title>Users & Actvities</title>
</head>
<body>
<table border="1">

    @if (!empty($users))
        <tr></tr>
        <tr>
            <td>Sr no</td>
            <td>User Id</td>
            <td>User Name</td>
            <td>Email</td>
            <td>First name</td>
            <td>Last Name</td>
            <td>Address</td>
            <td>City</td>
            <td>House Number</td>
            <td>Postal code</td>
            <td>Telephone number</td>
            <td>Created at</td>
            <td>Status</td>
            <td>Last Logged-in At</td>
        </tr>

        @php $increment = 1; @endphp

        @foreach ($users as $user)
            <tr>
                <td>{{ $increment  }}</td>
                <td>{{ $user['id'] }}</td>
                <td>{{ $user['user_name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['first_name'] }}</td>
                <td>{{ $user['last_name'] }}</td>
                <td>{{ $user['address'] }}</td>
                <td>{{ $user['city'] }}</td>
                <td>{{ $user['house_number'] }}</td>
                <td>{{ $user['postal_code'] }}</td>
                <td>{{ $user['telephone_number'] }}</td>
                <td>{{ $user['created_at'] }}</td>
                <td>
                    @if ($user['status'] == 1)
                        Active
                    @else
                        InActive
                    @endif
                </td>
                <td>{{ $user['last_sign_in_at'] ?
                ( $user['last_sign_in_at'][0]['created_at'] ?
                    \Carbon\Carbon::parse($user['last_sign_in_at'][0]['created_at'])->format('d-M-Y H:i') : '' )  : '' }}</td>
            </tr>

            @if (!empty($user['user_activity']))
                <tr>
                    <td></td>
                    <td>Sr No</td>
                    <td>Field Name</td>
                    <td>Old Value</td>
                    <td>Modified Value</td>
                    <td>Modified By</td>
                    <td colspan="7"></td>
                </tr>
                @php $count = 1; @endphp

                @foreach ($user['user_activity'] as $userHistory)
                    <tr>
                        <td></td>
                        <td>{{ $count }}</td>
                        <td>{{ $userHistory['field_name'] }}</td>
                        <td>{{ $userHistory['old_value'] }}</td>
                        <td>{{ $userHistory['new_value'] }}</td>
                        <td>{{ $userHistory['modified_by']['user_name'] }}</td>
                        <td colspan="7"></td>
                    </tr>

                    @php $count++; @endphp
                @endforeach
                <tr></tr>
            @endif

            @php $increment++; @endphp

        @endforeach
    @endif
</table>
</body>
</html>