
<table class="d-none">
    <tbody>
        <tr id="rowTemplate" class="d-none">
            
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
            <td>
                <select name="training_course_id[]" class="form-control trainingSelect" required>
                    <option value="">-- Select --</option>
                    <?php $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->id); ?>" data-name="<?php echo e($t->name); ?>" data-duration="<?php echo e($t->duration); ?>"
                        data-price="<?php echo e($t->price); ?>">
                        <?php echo e($t->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                
            </td>
            <td><input type="text" name="training_name[]" class="form-control trainingName" class="form-control trainingName"></td>
            <td><input type="text" name="duration[]" class="form-control duration" required></td>
            <td>
                <select name="delivery_mode[]" class="form-control delivery" required>
                    <option value="In-Class">In-Class</option>
                    <option value="Onsite">Onsite</option>
                    <option value="Online">Online</option>
                </select>
            </td>
            <td><input type="number" name="qty[]" class="form-control qty" value="1" required></td>
            <td><input type="number" name="unit_price[]" class="form-control price" value="0" required></td>
            <td><input type="number" name="discount[]" class="form-control discount" value="0"></td>
            <td><input type="number" name="total[]" class="form-control total" readonly></td>
        </tr>
    </tbody>
</table><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/view/row_template.blade.php ENDPATH**/ ?>