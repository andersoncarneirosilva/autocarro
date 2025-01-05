
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">
        <!-- Daterangepicker css -->
        <link href="{{ url('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ url('assets/vendor/daterangepicker/daterangepicker.css') }}">

        <!-- Vector Map css -->
        <link rel="stylesheet" href="{{ url('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
        <!-- Theme Config Js -->
        <script src="{{ url('assets/js/hyper-config.js') }}"></script>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

        
        <!-- App css -->
        <link href="{{ url('assets/css/app-saas.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0"></script>

        <!-- Icons css -->
        <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
<!-- Incluindo o jQuery Toast -->
        <script src="{{ url('js/mask-cep.js') }}"></script>
        <script src="{{ url('js/mask-phone.js') }}"></script>
        <!-- SimpleMDE css -->                                                 
<link href="{{ url('assets/vendor/simplemde/simplemde.min.css') }}" rel="stylesheet" />                                    
<!-- SimpleMDE js -->



        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin/dist/jquery.toast.min.css">

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Função para formatar a data
                function formatDate(dateString) {
                    //console.log('DATA RECEBIDA: ', dateString);
            
                    // Cria uma nova instância de Date com a string recebida
                    const date = new Date(dateString);
            
                    // Verifica se a data é válida
                    if (isNaN(date.getTime())) {
                        console.error("Data inválida em formatDate: ", dateString);
                        return 'Data inválida';
                    }
            
                    // Formata para o formato brasileiro (dd/mm/yyyy hh:mm)
                    return date.toLocaleString('pt-BR', { 
                        dateStyle: 'short', 
                        timeStyle: 'short' 
                    });
                }
            
                // Função para calcular o tempo passado
                function timeAgo(dateString) {
                    const now = new Date();
                    const date = new Date(dateString);
            
                    // Verifica se a data é válida
                    if (isNaN(date.getTime())) {
                        console.error("Data inválida em timeAgo: ", dateString);
                        return "Data inválida";
                    }
            
                    const diffInSeconds = Math.floor((now - date) / 1000);
            
                    if (diffInSeconds < 0) {
                        return "Data no passado"; // Para evitar valores negativos
                    }
            
                    if (diffInSeconds < 60) {
                        return ` há ${diffInSeconds} segundo${diffInSeconds === 1 ? '' : 's'}`;
                    }
            
                    const diffInMinutes = Math.floor(diffInSeconds / 60);
                    if (diffInMinutes < 60) {
                        return ` há ${diffInMinutes} minuto${diffInMinutes === 1 ? '' : 's'}`;
                    }
            
                    const diffInHours = Math.floor(diffInMinutes / 60);
                    if (diffInHours < 24) {
                        return ` há ${diffInHours} hora${diffInHours === 1 ? '' : 's'}`;
                    }
            
                    const diffInDays = Math.floor(diffInHours / 24);
                    return ` há ${diffInDays} dia${diffInDays === 1 ? '' : 's'}`;
                }
            
                // Função para buscar as notificações
                function getNotifications() {
                    fetch('/notifications', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        //console.log('DATA JS: ',data); // Exibe as notificações no console
            
                        const notificationsList = document.getElementById('notifications-list');
            
                        if (!notificationsList) {
                            console.error('Elemento #notifications-list não encontrado.');
                            return;
                        }
            
                        // Limpa as notificações anteriores
                        notificationsList.innerHTML = '';
            
                        if (data.length === 0) {
                            const noNotificationItem = document.createElement('li');
                            noNotificationItem.textContent = 'Não há notificações no momento.';
                            noNotificationItem.classList.add('dropdown-item', 'text-muted');
                            notificationsList.appendChild(noNotificationItem);
                        } else {
                            data.forEach(notification => {
                                const notificationItem = document.createElement('a');
                                notificationItem.href = 'javascript:void(0);';
                                notificationItem.classList.add('dropdown-item', 'p-0', 'notify-item', 'card', 'unread-noti', 'shadow-none', 'mb-2');
            
                                const formattedDate = formatDate(notification.data.event_date);
                                const timeElapsed = timeAgo(notification.data.created_at);
            
                                notificationItem.innerHTML = `
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="mdi mdi-comment-account-outline"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14" id="nome-evento">
                                                    ${notification.data.message}
                                                    <small class="fw-normal text-muted ms-1">${timeElapsed}</small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted" id="evento-criado">
                                                    ${notification.data.event_date ? `Criado em: ${formattedDate}` : 'Data não disponível'}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                `;
            
                                notificationsList.appendChild(notificationItem);
                            });
                        }
                    })
                    .catch(error => console.error('Erro ao buscar notificações:', error));
                }
            
                // Chama a função para buscar as notificações
                getNotifications();
            
                // Opcional: Recarregar as notificações a cada 10 segundos
                setInterval(getNotifications, 10000);
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
    z-index: 1055 !important; /* Certifique-se de que o z-index é maior que o do modal */
}

        </style>

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
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    

                                        
                                    
                                    

                                    
                                    @include('sweetalert::alert')
                                    @yield('content')
                                </div>
                            </div>
                        </div>
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
        <script src="{{ url('assets/vendor/select2/js/select2.min.js')}}"></script>
        <script src="{{ url('assets/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ url('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Input Mask js -->
        <script src="{{ url('assets/vendor/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
        <!-- plugin js -->
        <script src="{{ url('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>
        <!-- init js -->
        <script src="{{ url('assets/js/ui/component.fileupload.js') }}"></script>
        <!-- App js -->
        <script src="{{ url('assets/js/app.min.js') }}"></script>
        
        
        <script src="{{ url('assets/vendor/handlebars/handlebars.min.js') }}"></script>
        <script src="{{ url('assets/vendor/typeahead.js/typeahead.bundle.min.js') }}"></script>
        <!-- Script do Select2 -->
        <script src="{{ url('assets/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
        <!-- Toastr Demo js -->
    <script src="assets/js/pages/demo.toastr.js"></script>
        <script src="{{ url('assets/vendor/fullcalendar/index.global.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
        <script src="{{ url('assets/js/calendar.js') }}"></script>
        <script src="{{ url('assets/vendor/simplemde/simplemde.min.js') }}"></script>
<!-- SimpleMDE demo -->
<script src="{{ url('assets/js/pages/demo.simplemde.js') }}"></script>
    </body>
</html> 