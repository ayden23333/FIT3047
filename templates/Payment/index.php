<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payment
 */
?>
<div class="payment index content">
    <?= $this->Html->link(__('New Payment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Payment') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Order_ID') ?></th>
                    <th><?= $this->Paginator->sort('Customer_ID') ?></th>
                    <th><?= $this->Paginator->sort('Payment_method') ?></th>
                    <th><?= $this->Paginator->sort('Price') ?></th>
                    <th><?= $this->Paginator->sort('Payment_ID') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payment as $payment): ?>
                <tr>
                    <td><?= $this->Number->format($payment->Order_ID) ?></td>
                    <td><?= $this->Number->format($payment->Customer_ID) ?></td>
                    <td><?= h($payment->Payment_method) ?></td>
                    <td><?= $this->Number->format($payment->Price) ?></td>
                    <td><?= $this->Number->format($payment->Payment_ID) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $payment->Payment_ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payment->Payment_ID]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payment->Payment_ID], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->Payment_ID)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
