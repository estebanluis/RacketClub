<div>
    <!--[if BLOCK]><![endif]--><?php if($datos): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Hora</th>
                    <th>Carril</th>
                </tr>
            </thead>
            <tbody>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dato): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($dato->name); ?></td>
                        <td><?php echo e($dato->hora); ?></td>
                        <td><?php echo e($dato->carril); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    <?php else: ?>
        <p>Todos los carriles estan disponobles</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/livewire/tabla-modal1.blade.php ENDPATH**/ ?>