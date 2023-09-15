<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chat') }}</title>
    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" x-data="modal">
<main class="">
    {{ $slot }}
</main>
<script>
    window.addEventListener('alpine:init', () => {
        Alpine.data('modal', () => ({
            modalOpen: false,
            quoteOpen: false,

            toggleModal() {
                this.modalOpen = !this.modalOpen
            },
            toggleQuote() {
                this.quoteOpen = !this.quoteOpen
            }
        }))
    })
</script>
@livewireScripts
</body>
</html>
