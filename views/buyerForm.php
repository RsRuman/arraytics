<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buyer || Store</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto px-4">
    <h1 class="text-center font-bold text-2xl mt-4">Create Buyer</h1>
    <form id="buyerForm" class="max-w-lg mx-auto mt-4">
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" id="amount" name="amount" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="buyer" class="block text-sm font-medium text-gray-700">Buyer</label>
            <input type="text" id="buyer" name="buyer" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="receipt_id" class="block text-sm font-medium text-gray-700">Receipt ID</label>
            <input type="text" id="receipt_id" name="receipt_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="items" class="block text-sm font-medium text-gray-700">Items</label>
            <div id="itemsContainer" class="space-y-2">
                <div class="flex items-center">
                    <input type="text" name="items[]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Item">
                    <button type="button" id="addItem" class="ml-2 bg-blue-500 text-white px-2 py-1 rounded">Add</button>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label for="buyer_email" class="block text-sm font-medium text-gray-700">Buyer Email</label>
            <input type="email" id="buyer_email" name="buyer_email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
            <textarea id="note" name="note" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required></textarea>
        </div>
        <div class="mb-4">
            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" id="city" name="city" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" id="phone" name="phone" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="entry_by" class="block text-sm font-medium text-gray-700">Entry By</label>
            <input type="number" id="entry_by" name="entry_by" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Submit</button>
    </form>
    <script>
        $(document).ready(function() {
            // Handle adding new items
            $('#addItem').on('click', function() {
                $('#itemsContainer').append(`
                <div class="flex items-center">
                    <input type="text" name="items[]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Item" required>
                    <button type="button" class="ml-2 bg-red-500 text-white px-2 py-1 rounded removeItem">Remove</button>
                </div>
            `);
            });

            // Handle removing items
            $(document).on('click', '.removeItem', function() {
                $(this).parent().remove();
            });

            // Prevent multiple submissions within 24 hours
            if (document.cookie.split(';').some((item) => item.trim().startsWith('submitted='))) {
                alert('You have already submitted within the last 24 hours.');
                $('form').find('input, textarea, button').prop('disabled', true);
            }

            $('#buyerForm').on('submit', function(event) {
                // Check if any item field is empty
                let isValid = true;
                $('#itemsContainer input[name="items[]"]').each(function() {
                    if ($(this).val().trim() === '') {
                        alert('Item fields cannot be empty.');
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    return;
                }

                event.preventDefault();

                $.ajax({
                    url: 'index.php?action=store',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        // Set cookie to prevent further submissions within 24 hours
                        document.cookie = "submitted=true; max-age=" + (60 * 60 * 24) + "; path=/";
                    },
                    error: function() {
                        alert('An error occurred while submitting the form.');
                    }
                });
            });
        });
    </script>
</div>
</body>
</html>
