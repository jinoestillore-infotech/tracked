document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT BUTTONS
    |--------------------------------------------------------------------------
    | Add:
    | data-loading-form
    | data-loading-button
    */

    document.querySelectorAll('[data-loading-form]').forEach(form => {

        form.addEventListener('submit', () => {

            const button = form.querySelector('[data-loading-button]');

            if (!button) return;

            // Prevent multiple submit
            button.disabled = true;

            // Save original text
            if (!button.dataset.originalText) {
                button.dataset.originalText =
                    button.querySelector('.btn-text')?.innerHTML ||
                    button.innerHTML;
            }

            // Show loading text
            const textEl = button.querySelector('.btn-text');

            if (textEl) {
                textEl.innerHTML = 'Processing...';
            }

            // Show spinner
            const spinner = button.querySelector('.spinner-border');

            if (spinner) {
                spinner.classList.remove('d-none');
            }
        });

    });


    /*
    |--------------------------------------------------------------------------
    | DELETE / ACTION BUTTONS
    |--------------------------------------------------------------------------
    | Add:
    | data-loading-action
    */

    document.querySelectorAll('[data-loading-action]').forEach(button => {

        button.addEventListener('click', function (e) {

            const confirmMessage =
                this.dataset.confirm || 'Are you sure?';

            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return;
            }

            // Prevent multiple clicks
            this.classList.add('disabled');
            this.style.pointerEvents = 'none';

            // Change text
            const textEl = this.querySelector('.btn-text');

            if (textEl) {
                textEl.innerHTML = 'Processing...';
            }

            // Show spinner
            const spinner = this.querySelector('.spinner-border');

            if (spinner) {
                spinner.classList.remove('d-none');
            }
        });

    });

});