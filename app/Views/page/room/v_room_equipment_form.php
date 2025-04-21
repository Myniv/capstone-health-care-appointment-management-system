<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-bold mb-4"><?= isset($room_equipment) ? 'Edit Room Equipment' : 'Add Room Equipment'; ?>
    </h2>

    <form action="<?= base_url('admin/room/create/equipment/' . $room->id) ?>" method="post"
        enctype="multipart/form-data" id="formData" novalidate>
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="equipment" class="label">
                    <span class="label-text">Choose Equipment</span>
                </label>
                <select name="equipment" id="equipment"
                    class="select select-bordered w-full <?= session('errors.equipment') ? 'input-error' : '' ?>">
                    <option value="" disabled selected>Choose Equipment</option>
                    <?php foreach ($equipments as $equipment): ?>
                        <option value="<?= $equipment->id ?>" data-id="<?= $equipment->id ?>"
                            data-stock="<?= $equipment->stock ?>" data-name="<?= $equipment->name ?>">
                            <?= $equipment->name ?> (Available: <?= $equipment->stock ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="btn btn-primary mt-2" id="addEquipment">Add Equipment</button>
                <div class="text-error text-sm"><?= session('errors.equipment') ?? '' ?></div>
            </div>
        </div>

        <input type="hidden" name="equipmentIds" id="equipmentIds"
            value="<?= isset($room_equipment) ? implode(',', array_map(fn($equipment) => "{$equipment->equipment_id}:{$equipment->quantity}", $room_equipment)) : '' ?>">

        <input type="hidden" name="deletedEquipmentIds" id="deletedEquipmentIds" value="">

        <h5 class="text-2xl font-bold mb-4">Equipment List:</h5>
        <ul id="equipmentList" class="list-group mb-3">
            <!-- Equipment items will be rendered here by JavaScript -->
        </ul>

        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                Save Room Equipment
            </button>
        </div>
    </form>
</div>

<script>
    // Initialize equipment list from existing data
    let selectedEquipment = <?= isset($room_equipment) ? json_encode(array_map(fn($equipment) => [
        'id' => $equipment->equipment_id,
        'total' => intval($equipment->quantity), // Ensure it's a number
        'name' => $equipment->name,
        'stock' => intval($equipment->stock) // Ensure it's a number
    ], $room_equipment)) : '[]' ?>;

    // Keep track of available stock for each equipment
    let availableStock = {};

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize available stock
        <?php foreach ($equipments as $equipment): ?>
            availableStock['<?= $equipment->id ?>'] = <?= intval($equipment->stock) ?>; // Ensure it's a number
        <?php endforeach; ?>

        // Update available stock based on currently selected equipment
        // selectedEquipment.forEach(item => {
        //     if (availableStock[item.id] !== undefined) {
        //         availableStock[item.id] -= parseInt(item.total);
        //     }
        // });

        // Initialize the equipment list when the page loads
        renderEquipmentList();
        updateSelectOptions();

        // Add event listener for the "Add Equipment" button
        document.getElementById('addEquipment').addEventListener('click', addEquipment);
    });

    function addEquipment() {
        const select = document.getElementById('equipment');
        if (select.selectedIndex <= 0) return; // Don't proceed if nothing is selected

        const selectedOption = select.options[select.selectedIndex];
        const optionId = selectedOption.getAttribute('data-id');
        const optionStock = parseInt(selectedOption.getAttribute('data-stock'), 10);
        const optionName = selectedOption.getAttribute('data-name');

        // Check if we have stock available
        if (availableStock[optionId] <= 0) {
            alert('No more stock available for this equipment.');
            return;
        }

        // Find existing equipment
        let existingEquipment = selectedEquipment.find(equipment => equipment.id === optionId);

        if (existingEquipment) {
            // Check if adding one more would exceed the stock
            if (availableStock[optionId] > 0) {
                existingEquipment.total = parseInt(existingEquipment.total) + 1; // Ensure numeric addition
                availableStock[optionId]--;
                renderEquipmentList(); // Re-render the list
            } else {
                alert('Maximum available stock reached for this equipment.');
            }
        } else {
            // Create new equipment entry
            let newEquipment = {
                id: optionId,
                total: 1,
                name: optionName,
                stock: optionStock
            };
            selectedEquipment.push(newEquipment);
            availableStock[optionId]--;
            renderEquipmentList(); // Re-render the list
        }

        updateHiddenInput(); // Update the hidden input
        updateSelectOptions(); // Update the select options to show current available stock
    }

    function updateQuantity(equipmentId, change) {
        equipmentId = String(equipmentId); // Convert to string for consistent comparison
        const equipment = selectedEquipment.find(equipment => equipment.id === equipmentId);

        if (equipment) {
            // Convert to numbers and then perform arithmetic
            change = parseInt(change);

            // Handle quantity changes differently based on whether we're increasing or decreasing
            if (change > 0) { // Increasing quantity
                // Check if adding would exceed stock
                if (availableStock[equipmentId] <= 0) {
                    alert('Maximum available stock reached for this equipment.');
                    return;
                }

                equipment.total = parseInt(equipment.total) + change; // Ensure numeric addition
                availableStock[equipmentId] -= change; // Decrease available stock
            } else { // Decreasing quantity
                equipment.total = parseInt(equipment.total) + change; // Decrease the total (since change is negative)
                availableStock[equipmentId] -= change; // Add back to available stock (negative of negative is positive)
            }

            if (equipment.total <= 0) {
                removeEquipment(equipmentId);
            } else {
                renderEquipmentList(); // Re-render the list
                updateHiddenInput();
                updateSelectOptions(); // Update select options
            }
        }
    }

    function removeEquipment(equipmentId) {
        equipmentId = String(equipmentId); // Convert to string for consistent comparison
        const equipment = selectedEquipment.find(eq => eq.id === equipmentId);

        if (equipment) {
            // Return the stock to available pool
            availableStock[equipmentId] = parseInt(availableStock[equipmentId]) + parseInt(equipment.total);
        }

        selectedEquipment = selectedEquipment.filter(eq => eq.id !== equipmentId);
        renderEquipmentList(); // Re-render the list
        updateDeletedHiddenInput();
        updateHiddenInput();
        updateSelectOptions(); // Update select options
    }

    function renderEquipmentList() {
        const equipmentList = document.getElementById('equipmentList');
        equipmentList.innerHTML = ''; // Clear the list

        selectedEquipment.forEach(equipment => {
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item', 'flex', 'justify-between', 'items-center', 'mb-2', 'p-2', 'border', 'rounded');
            listItem.setAttribute('id', 'equipment-item-' + equipment.id);

            // Determine if we can add more of this equipment
            const canAddMore = availableStock[equipment.id] > 0;

            listItem.innerHTML = `
                <span>${equipment.name} (Quantity: <span class="font-bold">${parseInt(equipment.total)}</span>)</span>
                <div>
                    <button type="button" onclick="updateQuantity('${equipment.id}', -1)" class="btn btn-sm btn-error">-</button>
                    <button type="button" onclick="updateQuantity('${equipment.id}', 1)" class="btn btn-sm btn-success" ${canAddMore ? '' : 'disabled'}>+</button>
                    <button type="button" onclick="removeEquipment('${equipment.id}')" class="btn btn-sm btn-error">Remove</button>
                </div>
            `;
            equipmentList.appendChild(listItem);
        });
    }

    function updateSelectOptions() {
        const select = document.getElementById('equipment');

        // Update the text for each option to show current available stock
        for (let i = 0; i < select.options.length; i++) {
            const option = select.options[i];
            const equipmentId = option.getAttribute('data-id');

            if (equipmentId) {
                const originalStock = parseInt(option.getAttribute('data-stock'), 10);
                const currentAvailable = parseInt(availableStock[equipmentId] || 0);

                const equipmentName = option.getAttribute('data-name');
                option.text = `${equipmentName} (Available: ${currentAvailable})`;

                // Disable option if no stock available
                option.disabled = currentAvailable <= 0;
            }
        }
    }

    function updateHiddenInput() {
        document.getElementById('equipmentIds').value = selectedEquipment.map(equipment =>
            `${equipment.id}:${parseInt(equipment.total)}`
        ).join(',');
    }

    function updateDeletedHiddenInput() {
        document.getElementById('deletedEquipmentIds').value = selectedEquipment.map(equipment =>
            `${equipment.id}:${parseInt(equipment.total)}:${equipment.name}`
        ).join(',');
    }
</script>
<?= $this->endSection(); ?>