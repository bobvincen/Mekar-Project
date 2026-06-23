<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mekar Pharmacy</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

    @yield('content')

    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.toggle-password');
            if (btn) {
                const container = btn.parentElement;
                const input = container.querySelector('input');
                if (!input) return;

                const eyeIcon = btn.querySelector('.eye-icon');
                const eyeSlashIcon = btn.querySelector('.eye-slash-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                    btn.setAttribute('aria-label', 'Sembunyikan Password');
                } else {
                    input.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                    btn.setAttribute('aria-label', 'Tampilkan Password');
                }
            }
        });
    </script>
</body>
</html>
