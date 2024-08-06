<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buyer || Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto px-4 mb-4 mt-2">
    <h1 class="text-center font-bold text-2xl">Buyer List</h1>
    <div class="flex justify-end mb-2">
        <a class="align-middle select-none font-sans font-bold text-center uppercase bg-blue-900 text-white p-2 rounded" href="?action=create">
            Create
        </a>
    </div>

    <!-- Filter Form -->
    <div class="mb-4">
        <form method="get" class="flex space-x-4">
            <input type="hidden" name="action" value="report">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars(isset($_GET['start_date']) ? $_GET['start_date'] : '') ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars(isset($_GET['end_date']) ? $_GET['end_date'] : '') ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                <input type="number" id="user_id" name="user_id" value="<?= htmlspecialchars(isset($_GET['user_id']) ? $_GET['user_id'] : '') ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="flex items-end">
                <button type="submit" class="mt-1 p-2 bg-blue-600 text-white rounded">Filter</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="shadow-lg rounded-lg overflow-hidden">
        <table class="w-full table-fixed">
            <thead>
            <tr class="bg-gray-100">
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Amount</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Buyer</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Receipt ID</th>
                <th class="w-2/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Items</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Email</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">IP</th>
                <th class="w-2/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Note</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">City</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Phone</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Date</th>
                <th class="w-1/12 py-4 px-6 text-left text-gray-600 font-bold uppercase">Entry By</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $buyer): ?>
                    <tr>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['amount']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['buyer']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['receipt_id']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['items']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['buyer_email']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['buyer_ip']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['note']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['city']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['phone']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['entry_at']) ?></td>
                        <td class="py-4 px-6 border-b border-gray-200"><?= htmlspecialchars($buyer['entry_by']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="py-4 px-6 text-center text-gray-500">No data available.</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>
