<div class="col-md-12">
    <h3>PayPal Transactions</h3>
</div>
<ul class="list-group">
    <div class="col-md-12">
        @if(!$payments)
            <li class="list-group-item">
                <h4>There are no PayPal payments.</h4>
            </li>
        @else
    </div>
    <div class="col-md-6">
        @foreach($payments->payments as $payment)
            <li class="list-group-item">
                <h4>
                    {{ $payment->transactions[0]->item_list->items[0]->name }},
                    {{ $payment->transactions[0]->item_list->items[0]->price }} €
                </h4>
                <h4>
                    {{ $payment->id }}, {{ date_format(Carbon\Carbon::parse($payment->create_time), 'd.m.Y H:i:s') }}
                </h4>
            </li>
        @endforeach
    </div>
    <div class="col-md-6">
        @foreach($payments2->payments as $payment)
            <li class="list-group-item">
                <h4>
                    {{ $payment->transactions[0]->item_list->items[0]->name }},
                    {{ $payment->transactions[0]->item_list->items[0]->price }} €
                </h4>
                <h4>
                    {{ $payment->id }}, {{ date_format(Carbon\Carbon::parse($payment->create_time), 'd.m.Y H:i:s') }}
                </h4>
            </li>
        @endforeach
    </div>
    @endif
</ul>