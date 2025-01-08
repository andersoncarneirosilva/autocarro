
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