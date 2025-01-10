<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

    <!-- Title -->
    <title>@lang('dash::dash.login')</title>
    <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/fonts/cairo/style.css') }}" />
    <!--Favicon -->
    <link rel="icon" href="{{ url(config('dash.DASHBOARD_ICON')) }}" type="image/x-icon" />

    <!-- Bootstrap css -->
    <link href="{{ url('dashboard/assets/dashtemplate') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    @if (app()->getLocale() == 'ar')
        <link href="{{ url('dashboard/assets/dashtemplate') }}/plugins/bootstrap/css/bootstrap.rtl.min.css"
            rel="stylesheet" />
        <style>
            .form-label,
            .custom-checkbox,
            input {
                float: right;
                direction: rtl;
            }
        </style>
    @endif
    <!-- Style css -->
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/style.min.css" rel="stylesheet" />
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/boxed.css" rel="stylesheet" />
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/dark.css" rel="stylesheet" />
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/skin-modes.css" rel="stylesheet" />
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/transparent-style.css" rel="stylesheet">

    <!-- Animate css -->
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/animated.css" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{ url('dashboard/assets/dashtemplate') }}/css/icons.css" rel="stylesheet" />

</head>

<body class="">

    <div class="page  responsive-log login-bg">
        <div class="page-single">
            <div class="col-12">
                @if (session()->has('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="container">
                <div class="row">

                    <div class="col mx-auto">
                        <div class="row justify-content-center">

                            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 text-center">
                                <img src="{{ $DASHBOARD_ICON }}" style="max-height:70px" alt="{{ env('APP_NAME') }}">
                            </div>

                            <div class="col-md-8 col-lg-6 col-xl-4 col-xxl-4">
                                <div class="card my-5">
                                    <div class="p-4 pt-6 text-center">
                                        <h1 class="mb-2">@lang('dash::dash.login')</h1>
                                        {{--  <p class="text-muted">Sign In to your account</p>  --}}
                                    </div>
                                    <form class="card-body pt-3" id="login" method="post"
                                        action="{{ route(app('dash')['DASHBOARD_PATH'] . '.login') }}">
                                        @csrf
                                        <input type="hidden" name="lang" value="{{ request('lang') }}" />
                                        <div class="form-group">
                                            <label class="form-label">@lang('dash::dash.email')</label>
                                            <div class="input-group mb-4">
                                                <div class="input-group">
                                                    <a href="#" class="input-group-text">
                                                        <i class="fe fe-mail" aria-hidden="true"></i>
                                                    </a>
                                                    <input
                                                        class="form-control {{ !empty($errors) && $errors->has('email') ? 'is-invalid' : '' }}"
                                                        type="email" name="email" value="{{ old('email') }}"
                                                        value="{{ old('email') }}" placeholder="@lang('dash::dash.email')">
                                                    @error('email')
                                                        <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang('dash::dash.password')</label>
                                            <div class="input-group mb-4">
                                                <div class="input-group" id="Password-toggle">
                                                    <a href="#" class="input-group-text">
                                                        <i class="fe fe-eye-off" aria-hidden="true"></i>
                                                    </a>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control {{ !empty($errors) && $errors->has('password') ? 'is-invalid' : '' }}"
                                                        placeholder="@lang('dash::dash.password')">
                                                    @error('password')
                                                        <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="remember_me"
                                                    value="yes">
                                                <span class="custom-control-label">@lang('dash::dash.remember_me')</span>
                                            </label>
                                        </div>
                                        <div class="submit">
                                            <button class="btn btn-primary btn-block"
                                                type="submit">@lang('dash::dash.signin')</button>
                                        </div>
                                        <div class="text-center mt-3">
                                            {{--  <p class="mb-2"><a  href="javascript:void(0);">Forgot Password</a></p>  --}}

                                        </div>
                                    </form>
                                    <div class="card-body border-top-0 pb-6 pt-2">
                                        <div class="text-center">
                                            @if (!empty($DASHBOARD_LANGUAGES) && count($DASHBOARD_LANGUAGES) > 1)
                                                @php $i=1; @endphp
                                                @foreach ($DASHBOARD_LANGUAGES as $key => $value)
                                                    <a
                                                        href="{{ url($DASHBOARD_PATH . '/change/language/' . $key) }}?lang={{ request('lang') }}">
                                                        <small>{{ $value }}</small>
                                                    </a> {{ count($DASHBOARD_LANGUAGES) > $i ? ',' : '' }}
                                                    @php $i++; @endphp
                                                @endforeach
                                                <hr />
                                                @if (!empty(config('dash.copyright')))
                                                    <a href="{{ config('dash.copyright.link') }}"
                                                        class="font-weight-bold"
                                                        target="_blank">{!! config('dash.copyright.copyright_text') !!}</a>
                                                @else
                                                    Copyright © {{ date('Y') }},
                                                    Dashboard <span class="fa fa-heart text-danger"></span> by
                                                    <a href="https://phpdash.com" class="font-weight-bold"
                                                        target="_blank"> phpdash.com
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery js-->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/plugins/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#Password-toggle .input-group-text').on('click', function(e) {
                e.preventDefault(); // Prevent default anchor tag behavior

                const passwordInput = $('#password'); // Select the password input
                const icon = $(this).find('i'); // Select the icon inside the clicked element

                // Toggle password visibility
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text'); // Change input type to text
                    icon.removeClass('fe-eye-off').addClass('fe-eye'); // Change icon class
                } else {
                    passwordInput.attr('type', 'password'); // Change input type to password
                    icon.removeClass('fe-eye').addClass('fe-eye-off'); // Change icon class back
                }
                return false;
            });
        });
    </script>
    <!-- Bootstrap js-->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{{ url('dashboard/assets/dashtemplate') }}/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Select2 js -->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/plugins/select2/select2.full.min.js"></script>

    <!-- P-scroll js-->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/plugins/p-scrollbar/p-scrollbar.js"></script>

    <!--Sticky js -->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/js/sticky.js"></script>

    <!-- Color Theme js -->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/js/themeColors.js"></script>

    <!-- custom js -->
    <script src="{{ url('dashboard/assets/dashtemplate') }}/js/custom.js"></script>

</body>

</html>
