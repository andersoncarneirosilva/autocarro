{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({ 
                icon: 'success', 
                title: '{{ session('success') }}' 
            });
        @endif

        @if (session('error'))
            Toast.fire({ 
                icon: 'error', 
                title: '{{ session('error') }}' 
            });
        @endif
    });
</script>
@endif