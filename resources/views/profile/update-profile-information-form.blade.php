<div class="card mb-4">
    {{-- <div class="card-header">
        {{ __('Profile Information') }}
    </div> --}}
    <div class="card-body">
        <h5 class="mb-4">{{ __('Account Information') }}</h5>
        
        <div class="mt-3">
            <form action="{{ route('user-profile-information.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Account Name') }}</label>

                    <div class="col-md-6">
                        <input readonly id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') ?? auth()->user()->name }}" required autocomplete="name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contactName" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                    <div class="col-md-6">
                        <input readonly id="contactName" type="text" class="form-control @error('contactName') is-invalid @enderror"
                            name="contactName" value="{{ old('contactName') ?? auth()->user()->contactName }}" required autocomplete="contactName">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input readonly id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('name') ?? auth()->user()->email }}" required
                            autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{--<div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update Profile') }}
                        </button>
                    </div>
                </div>--}}
            </form>
        </div>
    </div>


</div>
