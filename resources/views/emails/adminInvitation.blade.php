<table>
    <tbody>
        <tr style="margin-bottom: 25px">
            <td><p>Please go to this <a href="{{ url('/admin') }}">link</a> for activate you account</p></td>
        </tr>
        <tr>
            <td><p>Email: {{ $email }}</p></td>
        </tr>
        <tr>
            <td><p>Temporary password: {{ $password }}</p></td>
        </tr>
    </tbody>
</table>