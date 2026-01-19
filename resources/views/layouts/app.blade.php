<!DOCTYPE html>
<html lang="pt-BR">

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

    <link rel="shortcut icon" href="{{ url('frontend/images/favicon/favicon.ico') }}">
    {{-- <script src="{{ url('backend/js/notificacoes.js') }}?v={{ time() }}"></script> --}}
    <!-- Daterangepicker css -->
    <link href="{{ url('backend/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ url('backend/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Vector Map css -->
    <link rel="stylesheet"
        href="{{ url('backend/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Theme Config Js -->
    <script src="{{ url('backend/js/hyper-config.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/backend/styles/choices.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/backend/scripts/choices.min.js"></script>

    <!-- App css -->

    <link rel="stylesheet" href="{{ url('backend/css/app-saas.css') }}?v={{ time() }}" type="text/css" id="app-style">

    <link rel="stylesheet" href="{{ url('backend/css/chat.css') }}?v={{ time() }}" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0"></script>

    <!-- Icons css -->
    <link href="{{ url('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('backend/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    
    <script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js" integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <script src="{{ url('backend/js/pagamento.js') }}?v={{ time() }}"></script> --}}

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-02FMMXT79W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-02FMMXT79W');
</script>

<!-- jstree css -->
<link href="{{ url('backend/vendor/jstree/themes/default/style.min.css') }}" rel="stylesheet" type="text/css">
{{-- DESENVOLVIMENTO --}}
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
<style>
    .avatar-stack {
    display: flex;
    position: relative;
}

.avatar-stack .avatar-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #ccc;
    margin-left: -16px;
    z-index: 1;
    transition: all 0.2s ease-in-out;
}

.avatar-stack .avatar-img:first-child {
    margin-left: 0;
    z-index: 3;
}
.avatar-stack .avatar-img:nth-child(2) {
    z-index: 2;
}
.avatar-stack .avatar-img:nth-child(3) {
    z-index: 1;
}
/* Mantendo o padrão do seu avatar-img */
.avatar-text {
    width: 32px; /* Ajustado para 32px conforme seu HTML anterior */
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #ccc;
    background-color: #730000; /* Cor do Alcecar */
    color: #fff;
    font-weight: bold;
    font-size: 13px;
    transition: all 0.2s ease-in-out;
}

/* Efeito de destaque ao passar o mouse */
.nav-link:hover .avatar-text {
    transform: scale(1.05);
    box-shadow: 0 0 0 1px #730000;
}



.upload-container {
  background-color: rgb(239, 239, 239);
  border-radius: 6px;
  padding: 10px;
}

.border-container {
  border: 5px dashed rgba(198, 198, 198, 0.65);
/*   border-radius: 4px; */
  padding: 20px;
}

.border-container p {
  color: #130f40;
  font-weight: 600;
  font-size: 1.1em;
  letter-spacing: -1px;
  margin-top: 30px;
  margin-bottom: 0;
  opacity: 0.65;
}

#file-browser {
  text-decoration: none;
  color: rgb(22,42,255);
  border-bottom: 3px dotted rgba(22, 22, 255, 0.85);
}

#file-browser:hover {
  color: rgb(0, 0, 255);
  border-bottom: 3px dotted rgba(0, 0, 255, 0.85);
}

.icons {
  color: #95afc0;
  opacity: 0.55;
}
#previewContainer img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .btn-remove-image {
  position: absolute;
  top: -6px;
  right: -6px;
  background-color: #dc3545;
  color: white;
  border: none;
  border-radius: 50%;
  font-weight: bold;
  width: 20px;
  height: 20px;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}

</style>
{{-- PRODUCAO --}}
                                    
<style>
                    /* Container da tabela para garantir que o arredondamento apareça */
                .table-rounded {
                    border-collapse: separate !important;
                    border-spacing: 0;
                    border: 1px solid #dee2e6; /* Borda externa opcional */
                    border-radius: 15px; /* Ajuste o raio conforme desejar */
                    overflow: hidden;
                }

                /* Arredonda o canto superior esquerdo (primeiro TH da primeira TR) */
                .table-rounded thead tr:first-child th:first-child {
                    border-top-left-radius: 15px;
                }

                /* Arredonda o canto superior direito (último TH da primeira TR) */
                .table-rounded thead tr:first-child th:last-child {
                    border-top-right-radius: 15px;
                }

                /* Remove a borda inferior da última linha para não ficar "quadrado" por dentro */
                .table-rounded tbody tr:last-child td:first-child {
                    border-bottom-left-radius: 15px;
                }
                .table-rounded tbody tr:last-child td:last-child {
                    border-bottom-right-radius: 15px;
                }
               .table-responsive,
.table-responsive-sm {
    overflow: visible !important;
}

.dropdown-menu {
    z-index: 1055;
}




                </style>

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ url('backend/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
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
    </style>

<style>
    /* 1. CONTAINER E TABELA */
    .table-responsive.rounded-4 {
        overflow: hidden; 
        border: 1px solid #eef2f7;
        background-color: #fff;
    }

   
    .user-row { transition: all 0.2s ease; }
    .user-row:hover { background-color: #f8f9fa; }

    /* 2. BOTÕES DE AÇÃO (SOFT STYLE) */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
        font-size: 16px;
    }

    .btn-action.edit {
        background-color: rgba(114, 124, 245, 0.15); /* Azul/Roxo suave */
        color: #727cf5;
    }
    .btn-action.edit:hover {
        background-color: #727cf5;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-action.delete {
        background-color: rgba(250, 92, 124, 0.15); /* Vermelho suave */
        color: #fa5c7c;
    }
    .btn-action.delete:hover {
        background-color: #fa5c7c;
        color: #fff;
        transform: translateY(-2px);
    }

    /* 3. BADGES MODERNAS */
    .bg-success-lighten {
        background-color: rgba(10, 207, 151, 0.15);
        color: #0acf97;
    }
    .bg-secondary-lighten {
        background-color: rgba(108, 117, 125, 0.15);
        color: #6c757d;
    }
    .bg-info-lighten {
        background-color: rgba(57, 175, 209, 0.15);
        color: #39afd1;
    }

    /* 4. BUSCA E OUTROS */
    .search-box .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 2px rgba(114, 124, 245, 0.1);
    }
    
    .btn-action i { line-height: 1; }
</style>
<style>
    /* Container que controla a rolagem e o arredondamento externo */
.table-custom-container {
    max-height: 550px;
    overflow-y: auto;
    overflow-x: auto;
    border: 1px solid #dee2e6;
    border-radius: 0.8rem !important;
    background-color: #ffffff;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Estilização da Tabela */
.table-custom {
    width: 100%;
    margin-bottom: 0 !important;
    border-collapse: separate;
    border-spacing: 0;
}

/* Cabeçalho Fixo e Estilizado */
.table-custom thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #313a46 !important;
    color: #ffffff !important;
    padding: 15px !important;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: 600;
    border: none;
    white-space: nowrap;
}

/* Arredondamento dos cantos superiores do cabeçalho */
.table-custom thead tr:first-child th:first-child { 
    border-top-left-radius: 0.8rem; 
}
.table-custom thead tr:first-child th:last-child { 
    border-top-right-radius: 0.8rem; 
}

/* Estilo das linhas e células */
.table-custom tbody td {
    padding: 12px 15px !important;
    vertical-align: middle;
    color: #6c757d;
    border-bottom: 1px solid #f1f3fa;
}

/* Efeito Hover nas linhas */
.table-custom tbody tr:hover {
    background-color: #f8f9fa;
}

/* Barra de rolagem elegante (opcional) */
.table-custom-container::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.table-custom-container::-webkit-scrollbar-thumb {
    background: #d1d3e2;
    border-radius: 10px;
}
</style>
</head>

<body>
   
    <!-- Pre-loader -->
    {{-- <div id="preloader">
            <div id="status">
              <div class="bouncing-loader">
                <div>P</div>
                <div>R</div>
                <div>O</div>
                <div>C</div>
              </div>
            </div>
          </div> --}}

    <!-- End Preloader-->
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
                    {{-- </div>
                            </div>
                        </div> --}}
                </div>
            </div>

            <!-- Footer Start -->
            @include('components.footer')
            <!-- end Footer -->

        </div>
    </div>
    <!-- Chart js -->
    <script src="{{ url('backend/vendor/chart.js/chart.min.js') }}"></script>
    <!-- Vendor js -->
    <script src="{{ url('backend/js/vendor.min.js') }}"></script>
    <script src="{{ url('backend/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ url('backend/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ url('backend/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Input Mask js -->
    <script src="{{ url('backend/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    <!-- plugin js -->
    <script src="{{ url('backend/vendor/dropzone/min/dropzone.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ url('backend/js/ui/component.fileupload.js') }}"></script>
    <!-- App js -->
    <script src="{{ url('backend/js/app.min.js') }}"></script>
    <script src="{{ url('backend/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ url('backend/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>


    <script src="{{ url('backend/vendor/handlebars/handlebars.min.js') }}"></script>
    <script src="{{ url('backend/vendor/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <!-- Script do Select2 -->
    <script src="{{ url('backend/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <!-- Toastr Demo js -->
    {{-- <script src="{{ url('backend/vendor/fullcalendar/index.global.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="{{ url('backend/js/calendar.js') }}"></script>
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    
    <!-- jstree js -->
    @if(request()->is('perfil'))
        <script src="{{ asset('backend/vendor/jstree/jstree.min.js') }}"></script>
    @endif

    
</body>

</html>
