<div>

    <button wire:click="updateLogger" class="btn btn-primary position-relative" style="padding-right: 50px;">
        <span wire:loading wire:target="updateLogger" class="spinner-container">
            <svg class="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </span>
        بروزرسانی </button>


    <style>
        .spinner-container {
            position: absolute;
            right: 10px;
            /* فاصله از سمت راست */
            top: 50%;
            transform: translateY(-50%);
            display: inline-block;
        }

        .spinner {
            animation: spin 1s linear infinite;
            width: 20px;
            height: 20px;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

</div>
