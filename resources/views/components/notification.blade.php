<div x-data="{ show: false, message: '' }" x-show="show" x-transition>
    <div
        class="fixed top-4 right-4 bg-red-600 text-white text-sm rounded-lg shadow-md px-4 py-2"
        x-text="message"
        x-on:show-notification.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000);"
    ></div>
</div>
