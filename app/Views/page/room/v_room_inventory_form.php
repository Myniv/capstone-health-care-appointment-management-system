<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <div class="mb-4">
        <?= view_cell('BackButtonCell', ['backLink' => null]) ?>
    </div>

    <h2 class="text-2xl font-bold mb-4"><?= isset($room_inventory) ? 'Edit Room Inventory' : 'Add Room Inventory'; ?>
    </h2>

    <form action="<?= base_url('admin/room/create-inventory/' . $room->id) ?>" method="post"
        enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="inventory" class="label">
                    <span class="label-text">Choose Inventory</span>
                </label>
                <select name="inventory" id="inventory"
                    class="select select-bordered w-full <?= session('errors.inventory') ? 'input-error' : '' ?>">
                    <option value="" disabled selected>Choose Inventory</option>
                    <?php foreach ($inventories as $inventory): ?>
                        <?php if ($inventory->status === 'Available'): ?>
                            <option value="<?= $inventory->id ?>" data-id="<?= $inventory->id ?>"
                                data-name="<?= $inventory->name ?>" data-serial_number="<?= $inventory->serial_number ?>"
                                <?= $inventory->status === 'Available' ? '' : 'disabled' ?>>
                                <?= $inventory->serial_number ?> - <?= $inventory->name ?> (<?= $inventory->status ?>)
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="btn btn-primary mt-2" id="addInventory">Add Inventory</button>
                <div class="text-error text-sm"><?= session('errors.inventory') ?? '' ?></div>
            </div>
        </div>

        <input type="hidden" name="inventoryIds" id="inventoryIds"
            value="<?= isset($room_inventory) ? implode(',', array_map(fn($inventory) => $inventory->inventory_id, $room_inventory)) : '' ?>">

        <!-- Hidden input for tracking deleted inventory IDs -->
        <input type="hidden" name="deletedInventoryIds" id="deletedInventoryIds" value="">

        <h5 class="text-2xl font-bold mb-4">Inventory List:</h5>
        <ul id="inventoryList" class="list-group mb-3">
            <!-- Inventory items will be rendered here by JavaScript -->
        </ul>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                Save Room Inventory
            </button>
        </div>
    </form>
</div>

<script>
    // Initialize inventory list from existing data
    let selectedInventory = <?= isset($room_inventory) ? json_encode(array_map(fn($inventory) => [
        'id' => $inventory->inventory_id,
        'name' => $inventory->inventory_name,
        'serial_number' => $inventory->inventory_serial_number
    ], $room_inventory)) : '[]' ?>;

    // Keep track of deleted inventory IDs
    let deletedInventoryIds = [];

    // Store original inventory IDs for tracking what's been deleted
    let originalInventoryIds = <?= isset($room_inventory) ? json_encode(array_map(fn($inventory) => $inventory->inventory_id, $room_inventory)) : '[]' ?>;

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the inventory list when the page loads
        renderInventoryList();
        updateSelectOptions();

        // Add event listener for the "Add Inventory" button
        document.getElementById('addInventory').addEventListener('click', addInventory);
    });

    function addInventory() {
        const select = document.getElementById('inventory');
        if (select.selectedIndex <= 0) return; // Don't proceed if nothing is selected

        const selectedOption = select.options[select.selectedIndex];
        const optionId = selectedOption.getAttribute('data-id');
        const optionName = selectedOption.getAttribute('data-name');
        const optionSerialNumber = selectedOption.getAttribute('data-serial_number');

        // Check if this inventory is already selected
        let existingInventory = selectedInventory.find(inventory => inventory.id === optionId);

        if (existingInventory) {
            alert('This inventory is already added to the room.');
            return;
        } else {
            // Create new inventory entry
            let newInventory = {
                id: optionId,
                name: optionName,
                serial_number: optionSerialNumber
            };
            selectedInventory.push(newInventory);

            // If this was previously deleted, remove it from deletedInventoryIds
            const deletedIndex = deletedInventoryIds.indexOf(optionId);
            if (deletedIndex > -1) {
                deletedInventoryIds.splice(deletedIndex, 1);
                updateDeletedInventoryIds();
            }

            renderInventoryList(); // Re-render the list
        }

        updateHiddenInput(); // Update the hidden input
        updateSelectOptions(); // Update the select options
    }

    function removeInventory(inventoryId) {
        inventoryId = String(inventoryId); // Convert to string for consistent comparison

        // If this was in the original inventory list, add to deletedInventoryIds
        if (originalInventoryIds.includes(inventoryId)) {
            if (!deletedInventoryIds.includes(inventoryId)) {
                deletedInventoryIds.push(inventoryId);
                updateDeletedInventoryIds();
            }
        }

        selectedInventory = selectedInventory.filter(inv => inv.id !== inventoryId);
        renderInventoryList(); // Re-render the list
        updateHiddenInput();
        updateSelectOptions(); // Update select options
    }

    function renderInventoryList() {
        const inventoryList = document.getElementById('inventoryList');
        inventoryList.innerHTML = ''; // Clear the list

        selectedInventory.forEach(inventory => {
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item', 'flex', 'justify-between', 'items-center', 'mb-2', 'mt-2', 'p-2', 'border', 'rounded');
            listItem.setAttribute('id', 'inventory-item-' + inventory.id);

            listItem.innerHTML = `
                <div class="flex items-center gap-2">
                    <span>${inventory.serial_number} - ${inventory.name}</span>
                    <div>
                        <button type="button" onclick="removeInventory('${inventory.id}')" class="btn btn-sm btn-error">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            inventoryList.appendChild(listItem);
        });
    }

    function updateSelectOptions() {
        const select = document.getElementById('inventory');

        // Update the select options - disable options that are already selected
        for (let i = 0; i < select.options.length; i++) {
            const option = select.options[i];
            const inventoryId = option.getAttribute('data-id');

            if (inventoryId) {
                // Check if this inventory is already in the selected list
                const isSelected = selectedInventory.some(inv => inv.id === inventoryId);
                option.disabled = isSelected;
            }
        }
    }

    function updateHiddenInput() {
        document.getElementById('inventoryIds').value = selectedInventory.map(inventory => inventory.id).join(',');
    }

    function updateDeletedInventoryIds() {
        document.getElementById('deletedInventoryIds').value = deletedInventoryIds.join(',');
    }
</script>
<?= $this->endSection(); ?>