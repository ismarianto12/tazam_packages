<div>

    <div class="login-brand">
        <img src="{{ asset('/template') }}/assets/img/logo_pbs.png" alt="logo" width="200">
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>TABUNGAN ZAM ZAM</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="actionprocess" class="needs-validation" novalidate="">
                <div class="form-group">
                    <label for="email">Username</label>
                    <input id="email" type="email" class="form-control @error('username') is-invalid @enderror"
                        name="email" tabindex="1" wire:model="username">
                    @error('username')
                        <div class="invalid-feedback">
                            Username harus di isi
                        </div>
                    @enderror

                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        <div class="float-right">
                            <a href="auth-forgot-password.html" class="text-small">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" tabindex="1" wire:model="password">
                    @error('password')
                        <div class="invalid-feedback">
                            password harus di isi
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                            id="remember-me">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>
            @if (Session::has('message'))
                {!! session('message') !!}
            @endif
        </div>
    </div>
</div>
