<div class="table-responsive">
    <label for="datepicker">SELECT END DATE FOR PAYOUT</label>
    <form wire:submit.prevent='getMerchantTransactions'>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" wire:model.defer='endDate' min="{{ date('Y-m-d', strtotime('tomorrow')) }}"
                        class="form-control" value="{{ $endDate ?? '' }}">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>
                    <div class="d-flex align-items-baseline">
                        <input id="check" wire:model='allTransactions' type="checkbox" name="" class="mr-1"
                            id="">

                        <label for="check" class="mr-2">All</label>
                    </div>
                </th>
                <th>Merchant Name</th>
                <th>Total Collected</th>
                <th>Total Commission</th>
            </tr>
        </thead>
        <tbody>

            @if ($endDate)
                @forelse ($merchantsToIntiatePayouts as $merchant)
                    <tr>
                        <td>
                            <input wire:model='selectedTransactions' value="{{ $merchant->id }}" type="checkbox">
                        </td>
                        <td>
                            {{ $merchant->business_name }}
                        </td>
                        <td>{{ $merchant->transactions_sum_amount }}</td>
                        <td>{{ $merchant->transactions_sum_amount }}</td>

                    </tr>

                @empty
                    <tr>

                        <td></td>
                        <td></td>
                        <td> No transaction yet</td>
                        <td></td>

                    </tr>
                @endforelse
           


        </tbody>
    </table>

        @if (!empty($selectedTransactions) || !empty ($allTransactions))
        <form wire:click.prevent='initiatePayment'>
            <button type="submit" class="btn btn-primary">Initiate Payout</button>
        </form>
        @endif

    @else
    @endif
</div>
