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
            <?= $this->Html->link(__('Edit Payment'), ['action' => 'edit', $payment->Payment_ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Payment'), ['action' => 'delete', $payment->Payment_ID], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->Payment_ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Payment'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="payment view content">
            <h3><?= h($payment->Payment_ID) ?></h3>
            <table>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($payment->Payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order ID') ?></th>
                    <td><?= $this->Number->format($payment->Order_ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer ID') ?></th>
                    <td><?= $this->Number->format($payment->Customer_ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($payment->Price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment ID') ?></th>
                    <td><?= $this->Number->format($payment->Payment_ID) ?></td>
                </tr>

            </table>
        </div>
    </div>
</div>
