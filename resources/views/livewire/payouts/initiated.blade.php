<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="d-flex justify-content-end">
        <a href="{{ route('payouts.initiate') }}" class="btn btn-primary mr-2 mb-3">Initiate
            Payment</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>
                    <div class="d-flex align-items-baseline">
                        <input id="check" wire:model='allInitiatedPayouts' type="checkbox" class="mr-1">

                        <label for="check" class="mr-2">All</label>
                    </div>
                </th>
                <th>Merchant Name</th>
                <th>Total Collected</th>
                <th>Total Commission</th>
            </tr>
        </thead>
        <tbody>


            @forelse ($allMerchantInitiatedPayouts as $allMerchantInitiatedPayout)
                <tr>
                    <td>
                        <input wire:model='selectedTransactions' value="{{ $allMerchantInitiatedPayout->id }}"
                            type="checkbox">
                    </td>
                    <td>
                        {{ $allMerchantInitiatedPayout->business_name }}
                    </td>
                    <td>{{ $allMerchantInitiatedPayout->total_collected }}</td>
                    <td>{{ $allMerchantInitiatedPayout->total_recieved }}</td>

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
    @if (!empty($selectedTransactions) || !empty($allInitiatedPayouts))
        <div class="d-flex justify-content-start">
            <form wire:click.prevent='cancelPayout'>

                <button type="submit"class="btn btn-primary">Cancel Payout</button>
            </form>

            <form wire:click.prevent='completedPayout'>
                @method('PUT')
                <button type="submit" class="btn btn-primary">Complete Payout</button>
            </form>
        </div>
    @endif

</div>
