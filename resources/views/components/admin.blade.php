<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .active{
            background: rgb(172, 171, 171);
        }
    </style>
</head>
<body>
    <div>
       @include('components.layouts.admin.header')
          @include('components.layouts.admin.sidebar')
              <main>
                <div class="p-4 pt-14 sm:ml-64 mt-10">
                  {{ $slot }}
                    
                 </div>
              </main>


           </div>
        </div>
     </div>
     <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            initFlowbite();
            console.log('navigated');
        })
     </script>
</body>
</html>
