<div>
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


            @forelse ($cancelledPayouts as $cancelledPayout)
                <tr>
                    <td>
                        {{ $cancelledPayout->business_name }}
                    </td>
                    <td>{{ $cancelledPayout->total_collected }}</td>
                    <td>{{ $cancelledPayout->total_recieved }}</td>
                    <td>{{ $cancelledPayout->status }}</td>
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
