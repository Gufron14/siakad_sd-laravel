<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <h3>MDTA Fathul Uluum</h3>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue to Minible.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form wire:submit.prevent="login">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" wire:model.defer="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        id="email" placeholder="Enter Email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-muted">Forgot
                                                password?</a>
                                        @endif
                                    </div>
                                    <label class="form-label" for="userpassword">Password</label>
                                    <input type="password" wire:model.defer="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        id="userpassword" placeholder="Enter password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="d-flex gap-2 justify-content-end mt-3">
                                    <div>
                                        <a href="{{ route('/') }}"
                                            class="btn btn-secondary w-sm waves-effect waves-light fw-bold">Kembali</a>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary w-sm waves-effect waves-light fw-bold"
                                            type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
