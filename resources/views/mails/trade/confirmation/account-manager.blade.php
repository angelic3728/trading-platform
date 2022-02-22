@component('mail::message')
A new trade has been placed. See the details below

<strong>Trade Details:</strong>
<table class="table td-50">
    <tbody>
        <tr>
            <td>
                <strong>Action:</strong>
            </td>
            <td>{{ $action == 'buy' ? 'BUY' : 'SELL' }}</td>
        </tr>
        <tr>
            <td>
                <strong>Symbol:</strong>
            </td>
            <td>{{ $stock->symbol }}</td>
        </tr>
        <tr>
            <td>
                <strong>Company Name:</strong>
            </td>
            <td>{{ $stock->company_name }}</td>
        </tr>
        <tr>
            <td>
                <strong>Shares:</strong>
            </td>
            <td>{{ $shares }}</td>
        </tr>
        <tr>
            <td>
                <strong>Retail Price:</strong>
            </td>
            <td>{{ $stock->formatPrice($price) }}</td>
        </tr>
        @if($action == 'buy')
            <tr>
                <td>
                    <strong>Institutional Price:</strong>
                </td>
                <td>{{ $stock->formatPrice($institutional_price) }}</td>
            </tr>
        @endif
        <tr>
            <td>
                <strong>Date and Time ({{ config('app.timezone') }}):</strong>
            </td>
            <td>{{ $date->format('j F Y h:i:s A') }}</td>
        </tr>
    </tbody>
</table>

<strong>User Information:</strong>
<table class="table td-50">
    <tbody>
        <tr>
            <td>
                <strong>Name:</strong>
            </td>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
        </tr>
        <tr>
            <td>
                <strong>E-mail Address:</strong>
            </td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td>
                <strong>Phone Number:</strong>
            </td>
            <td>{{ $user->phone }}</td>
        </tr>
    </tbody>
</table>

Click below to process the transaction
@component('mail::button', ['url' => url('/admin/resources/transactions/new?viaResource=&viaResourceId=&viaRelationship=&price='.$institutional_price.'&shares='.($action == 'buy' ? $shares : (-1 * abs($shares))).'&stock_id='.$stock->id.'&user_id='.$user->id.'&type='.$action)])
Process Transaction
@endcomponent

@endcomponent
