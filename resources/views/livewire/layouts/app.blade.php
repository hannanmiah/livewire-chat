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
<body class="font-sans antialiased grid grid-cols-8" x-data="app">
<livewire:components.navigation key="navigation"/>

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
</body>
</html>

