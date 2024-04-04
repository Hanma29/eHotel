<?php if (hasOustandingErrors()): ?>

    <div class="errors-to-display">
        <?php echo getErrorsFormatted(); ?>
    </div>

<?php endif; ?>

<?php if (hasAlerts()): ?>

<div class="alerts-to-display">
    <?php echo getAlertsFormatted(); ?>
</div>

<?php endif; ?>