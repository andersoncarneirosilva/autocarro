<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="keywords"
        content="Gerenciamento de documentação, veículos, Procuração, CRLV, Solicitação de ATPVe, documentos veiculares">
    <meta name="description"
        content="Gerenciamento de documentação de veículos. Procuração, CRLV, solicitação de ATPVe e muito mais.">


    <!-- App favicon -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">
    <script src="{{ url('assets/js/notificacoes.js') }}?v={{ time() }}"></script>
    <!-- Daterangepicker css -->
    <link href="{{ url('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Vector Map css -->
    <link rel="stylesheet"
        href="{{ url('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Theme Config Js -->
    <script src="{{ url('assets/js/hyper-config.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- App css -->

    <link rel="stylesheet" href="{{ url('assets/css/app-saas.css') }}?v={{ time() }}" type="text/css"
        id="app-style">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0"></script>

    <!-- Icons css -->
    <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js" integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Incluindo o jQuery Toast -->
    <script src="{{ url('js/mask-cep.js') }}"></script>
    <script src="{{ url('js/mask-phone.js') }}"></script>

    {{-- <script src="{{ url('assets/js/pagamento.js') }}?v={{ time() }}"></script> --}}

<!-- jstree css -->
<link href="{{ url('assets/vendor/jstree/themes/default/style.min.css') }}" rel="stylesheet" type="text/css">

{{-- DESENVOLVIMENTO --}}
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

{{-- PRODUCAO --}}
@if (app()->environment('local'))
@vite(['resources/css/app.css', 'resources/js/app.js'])
@else
@php
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    $cssFile = $manifest['resources/css/app.css']['file'] ?? 'assets/app.css';  // Default case
    $jsFile = $manifest['resources/js/app.js']['file'] ?? 'assets/app.js';  // Default case
@endphp
<link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
<script type="module" src="{{ asset('build/' . $jsFile) }}" defer></script>
@endif
                        
<script>
    window.authUserId = {{ auth()->id() }};
    window.chatId = {{ $chat->id ?? 'null' }}; // Garante que chatId não fique undefined
</script>
    

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ url('assets/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy', // Formato de data brasileiro
                language: 'pt-BR', // Define o idioma como Português Brasil
                autoclose: true, // Fecha automaticamente ao selecionar a data
                todayHighlight: true // Destaca a data atual
            });

            // Para calendários inline
            $('.calendar-widget').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                todayHighlight: true
            });
        });
    </script>






    <!-- Select2 css -->


    <!--  Select2 Js -->


    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .filter-select {
            background-color: transparent;
            border: none;
            padding: 0 1em 0 0;
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            cursor: inherit;
            width: auto;
            line-height: inherit;
            outline: none;
            color: var(--ct-body-color);
        }

        .filter-btn {
            padding: 0.25em 0.5em;
            font-size: inherit;
            cursor: pointer;
            border-radius: 4px;
            color: var(--ct-body-color);
            border: none;
            color: #333;
        }

        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-body {
            padding: 0.5rem;
        }

        .filter-select-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .select2-container {
            z-index: 1055 !important;
            /* Certifique-se de que o z-index é maior que o do modal */
        }
        /* Estilo para mensagens do usuário (à esquerda) */
        #message-list {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                    }
                
                    .message {
                        display: flex;
                        width: 100%;
                        align-items: flex-end;
                    }
                
                    .user-message {
                        justify-content: flex-end;
                    }
                
                    .admin-message {
                        justify-content: flex-start;
                    }
                
                    .message-content {
                        max-width: 60%;
                        padding: 10px 15px;
                        border-radius: 10px;
                        position: relative;
                        font-size: 14px;
                        line-height: 1.4;
                    }
                
                    .user-message .message-content {
                        background-color: #dcf8c6;
                        color: #000;
                        border-radius: 10px 10px 0 10px;
                    }
                
                    .admin-message .message-content {
                        background-color: #fff;
                        color: #000;
                        border-radius: 10px 10px 10px 0;
                        border: 1px solid #ddd;
                    }
                
                    .message-time {
                        font-size: 12px;
                        color: #777;
                        margin-left: 8px;
                        white-space: nowrap;
                    }
                    .ctext-wrap {
    border-radius: 10px 10px 0 10px;
    border: 1px solid #ddd;
    color: #000;
    padding: 10px 15px; /* O padding define o espaço interno da borda */
    box-sizing: border-box; /* Garante que o padding e a borda sejam incluídos no cálculo da largura total */
    word-wrap: break-word; /* Garante que o texto quebre corretamente */
    display: inline-block; /* Permite que a largura da borda se ajuste ao conteúdo da mensagem */
}


    </style>
    @livewireStyles

</head>


<body>

    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Topbar Start ========== -->
        @include('components.navbar')
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('components.sidebar')
        <!-- ========== Left Sidebar End ========== -->

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    {{-- <div class="row">
                            <div class="col-12">
                                <div class="page-title-box"> --}}







                    @include('sweetalert::alert')
                    @yield('content')
                    
                    @livewire('chat')

    {{-- @vite(['resources/js/app.js']) --}}
    @livewireScripts 
                </div>
            </div>

            <!-- Footer Start -->
            @include('components.footer')
            <!-- end Footer -->

        </div>
    </div>
    <!-- Chart js -->
    <script src="{{ url('assets/vendor/chart.js/chart.min.js') }}"></script>
    <!-- Vendor js -->
    <script src="{{ url('assets/js/vendor.min.js') }}"></script>
    <script src="{{ url('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ url('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ url('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Input Mask js -->
    <script src="{{ url('assets/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    <!-- plugin js -->
    <script src="{{ url('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ url('assets/js/ui/component.fileupload.js') }}"></script>
    <!-- App js -->
    <script src="{{ url('assets/js/app.min.js') }}"></script>
    <script src="{{ url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ url('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>


    <script src="{{ url('assets/vendor/handlebars/handlebars.min.js') }}"></script>
    <script src="{{ url('assets/vendor/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <!-- Script do Select2 -->
    <script src="{{ url('assets/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <!-- Toastr Demo js -->
    {{-- <script src="{{ url('assets/vendor/fullcalendar/index.global.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="{{ url('assets/js/calendar.js') }}"></script>
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    
    <!-- jstree js -->
    @if(request()->is('perfil'))
        <script src="{{ asset('assets/vendor/jstree/jstree.min.js') }}"></script>
    @endif
</body>

</html>