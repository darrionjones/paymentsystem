<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <form wire:submit.prevent='submit' method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_number">Account Number<span class="text-danger">*</span></label>
                    <input type="text" name="account_number" wire:model.defer='accountNumber' id="account_number" class="form-control" required>
                    @error('accountNumber') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                    <input type="text" name="account_name" wire:model.defer='accountName' id="account_name" class="form-control" required>
                    @error('accountName') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">

            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label for="bank_name">Bank Name <span class="text-danger">*</span></label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" required>
                </div>
                
            </div> --}}

            <div class="col-md-6">
                <div class="form-group">
                    <label for="Bank">Bank Name <span class="text-danger">*</span></label>
                  
                    <select name="bank" wire:model='getMerchantBank' wire:model.defer='bankId' id="bank" class="form-control" required>
                        <option value="">Select Bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                        @endforeach
                    </select>
                    @error('bank') <span class="error">{{ $message }}</span> @enderror

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="Bank">Bank Branch <span class="text-danger">*</span></label>
                    <select name="bank" wire:model='branchName' id="bank" class="form-control" required>
                        <option value="">Select Branch</option>
                        @if ($getMerchantBank)
                            @foreach ($getMerchantbankbranches as $bank)
                                @foreach ($bank['branches'] as $branch)
                                    <option>{{ $branch['branch_name'] }}</option>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                    @error('branchName') <span class="error">{{ $message }}</span> @enderror
                </div>


            </div>
         <div class="container">
            <button type="submit" class="btn btn-primary  ">Add Bank</button>
         </div>




    </form>
</div>
