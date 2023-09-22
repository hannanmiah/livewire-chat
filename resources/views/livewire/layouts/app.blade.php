<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Livewire chat' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="app">
{{ $slot }}

<script>
    window.addEventListener('alpine:init', () => {
        Alpine.data('app', () => {
            return {
                createChatOpen: false,
                chatOpen: false,

                toggleCreateChat() {
                    this.createChatOpen = !this.createChatOpen
                },
                toggleChat() {
                    this.chatOpen = !this.chatOpen
                }
            }
        })
    })
</script>
@stack('scripts')
</body>
</html>
