<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Payment'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="payment form content">
            <?= $this->Form->create($payment) ?>
            <fieldset>
                <legend><?= __('Add Payment') ?></legend>
                <?php
                    echo $this->Form->control('Order_ID');
                    echo $this->Form->control('Customer_ID');
                    echo $this->Form->control('Payment_method');
                    echo $this->Form->control('Price');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
