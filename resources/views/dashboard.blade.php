<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mockup-code w-full">
                <pre data-prefix="$"><code>You're logged in!</code></pre>
            </div>
            <div class="collapse collapse-arrow bg-base-100 border border-base-300">
                <input type="radio" name="my-accordion-2" checked="checked" />
                <div class="collapse-title font-semibold">How do I create an account?</div>
                <div class="collapse-content text-sm">Click the "Sign Up" button in the top right corner and follow the
                    registration process.</div>
            </div>
            <div class="collapse collapse-arrow bg-base-100 border border-base-300">
                <input type="radio" name="my-accordion-2" />
                <div class="collapse-title font-semibold">I forgot my password. What should I do?</div>
                <div class="collapse-content text-sm">Click on "Forgot Password" on the login page and follow the
                    instructions sent to your email.</div>
            </div>
            <div class="collapse collapse-arrow bg-base-100 border border-base-300">
                <input type="radio" name="my-accordion-2" />
                <div class="collapse-title font-semibold">How do I update my profile information?</div>
                <div class="collapse-content text-sm">Go to "My Account" settings and select "Edit Profile" to make
                    changes.</div>
            </div>
            <details class="dropdown">
                <summary class="btn m-1">open or close</summary>
                <ul class="menu dropdown-content bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                    <li><a>Item 1</a></li>
                    <li><a>Item 2</a></li>
                </ul>
            </details>
            <!-- You can open the modal using ID.showModal() method -->
            <button class="btn" onclick="my_modal_3.showModal()">open modal</button>
            <dialog id="my_modal_3" class="modal">
                <div class="modal-box">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <h3 class="text-lg font-bold">Hello!</h3>
                    <p class="py-4">Press ESC key or click on ✕ button to close</p>
                </div>
            </dialog>
        </div>

    </div>
</x-app-layout>
