<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 bg-[#0E121B] dark:bg-gray-900">
            {{-- <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> --}}

            <div class="w-full sm:max-w-md mt-4 px-6 py-4  dark:bg-gray-800  overflow-hidden sm:rounded-lg">
                
                {{ $slot }}
            </div>
        </div>
        @fluxScripts
    </body>
</html>
