<div class="task_ajax_widget">
    <p class="payment"<?php if($rework->price <= 0) { ?> style="display: none;"<?php } ?>>
        Оплачено:<br />
        <input type="radio" name="ajax_rework_payment<?php echo $rework->id; ?>" class="ajax_rework_payment" id="ajax_rework_payment_no<?php echo $rework->id; ?>" value="no" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment == 'no') echo ' checked'; ?> />
        <label>Нет</label>
        
        <input type="radio" name="ajax_rework_payment<?php echo $rework->id; ?>" class="ajax_rework_payment" id="ajax_rework_payment_yes<?php echo $rework->id; ?>" value="yes" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment == 'yes') echo ' checked'; ?> />
        <label>Да</label>
        
        <br />
        
        Выплата сотруднику:<br />
        <input type="radio" name="ajax_rework_payment_perfomer<?php echo $rework->id; ?>" class="ajax_rework_payment_perfomer" id="ajax_rework_payment_no_perfomer<?php echo $rework->id; ?>" value="no" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment_perfomer == 'no') echo ' checked'; ?> />
        <label for="ajax_rework_payment_no_perfomer<?php echo $rework->id; ?>">Нет</label>
        
        <input type="radio" name="ajax_rework_payment_perfomer<?php echo $rework->id; ?>" class="ajax_rework_payment_perfomer" id="ajax_rework_payment_yes_perfomer<?php echo $rework->id; ?>" value="yes" data-id="<?php echo $rework->id; ?>" data-user-id="<?php echo $rework->perfomer_id; ?>" <?php if($rework->payment_perfomer == 'yes') echo ' checked'; ?> />
        <label for="ajax_rework_payment_yes_perfomer<?php echo $rework->id; ?>">Да</label>
    </p>
</div>