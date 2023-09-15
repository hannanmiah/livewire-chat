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
<body class="font-sans antialiased" x-data="app">
{{ $slot }}

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            chatOpen: false,
            createChatOpen: false,

            toggleChat() {
                this.chatOpen = !this.chatOpen;
            },
            toggleCreateChat() {
                this.createChatOpen = !this.createChatOpen;
            }
        }));
    });
</script>

@livewireScripts
@stack('scripts')
</body>
</html>

