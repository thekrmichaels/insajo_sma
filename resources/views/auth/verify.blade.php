@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7" style="margin-top: 2%">
                <div class="box">
                    <h3 class="box-title" style="padding: 2%">Verifica tu dirección de correo</h3>

                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                Un enlace de verificación ha sido enviado a su dirección de correo
                            </div>
                        @endif
                        <p>
                            Antes de continuar, por favor, revise el enlace de verificación enviado a su correo. Sino ha
                            recibido
                            el correo,
                        </p>

                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                            click aquí
                        </a>
                        <form id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
