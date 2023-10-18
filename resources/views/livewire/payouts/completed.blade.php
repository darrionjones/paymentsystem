<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <table class="table">
        <thead>
            <tr>
                <th>
                    <div class="d-flex align-items-baseline">

                        <label for="check" class="mr-2">All</label>
                    </div>
                </th>
                <th>Merchant Name</th>
                <th>Total Collected</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>


            @forelse ($completedPayouts as $completedPayout)
                <tr>
                    <td>
                        {{ $completedPayout->business_name }}
                    </td>
                    <td>{{ $completedPayout->total_collected }}</td>
                    <td>{{ $completedPayout->total_recieved }}</td>
                    <td>{{ $completedPayout->status }}</td>
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
</div>
