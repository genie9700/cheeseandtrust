<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('logo/chase2.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
     <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .active{
            background: rgb(172, 171, 171);
        }
    </style>
</head>
<body class="font-sans antialiased" style="font-family: 'Inter', 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div>
       @include('components.layouts.admin.header')
        @include('components.layouts.admin.sidebar')
        <main class="">
            <div class="p-4 pt-14 sm:ml-64 mt-10 min-h-screen dark:bg-gray-800">
                {{ $slot }}
            
            </div>
        </main>


           </div>
        </div>
     </div>
     <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

     <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            initFlowbite();
            console.log('navigated');
        })
     </script>
</body>
</html>
