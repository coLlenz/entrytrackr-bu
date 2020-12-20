@extends('layouts.app')

    @section('content')
    <section class="uk-section">
    <div class="uk-container">
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            @include('profile.update-password-form')
        @endif
    </div>
    </section>
    @endsection
